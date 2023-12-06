import hljs from "highlight.js";
import { Marked } from "marked";
import { markedHighlight } from "marked-highlight";
import markedLinkifyIt from "marked-linkify-it";
import { markedXhtml } from "marked-xhtml";

const marked = new Marked({
    gfm: true,
    silent: true,
});

const renderer = {
    code(code) {
        return `<pre class="relative"><code>${code}</code></pre>`;
    },
    image(href, _, text) {
        return `<div class="flex flex-col items-center"><img src="${href}" alt="${text}" style="margin-bottom: 3px;" loading="lazy"/><p class="text-sm">${text}</p></div>`;
    },
    heading(text, level) {
        return `<h${level} class="relative group hover:underline hover:cursor-pointer">
                    <a href="#${text}" id="${text}" class="absolute top-0 -left-8 no-underline hidden group-hover:inline">
                        <span># </span>
                    </a>
                    ${text}
                </h${level}>`;
    },
};

marked.use(
    markedHighlight({
        langPrefix: "hljs language-",
        highlight(code, lang) {
            const language = hljs.getLanguage(lang) ? lang : "plaintext";
            return hljs.highlight(code, { language }).value;
        },
    }),
);

marked.use(markedLinkifyIt());

marked.use(markedXhtml());

marked.use({ renderer });
export default marked;
