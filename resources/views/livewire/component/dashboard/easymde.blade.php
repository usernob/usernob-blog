<?php

use Livewire\Volt\Component;

new class () extends Component {
    public string $content = '';

    public function mount(string $content = "")
    {
        $this->content = $content;
    }

    public function with()
    {
        return [
            'content' => $this->content,
        ];
    }
}; ?>

<section class="mt-10 bg-background2" x-cloak>
    <textarea name="mde" id="mde" data-src="{{ $content }}">

    </textarea>
    <script>
        window.addEventListener("alpine:init", () => {
            const content = document.getElementById("mde");
            const contentInput = document.getElementById("content");
            const easyMDE = new EasyMDE({
                element: content,
                previewClass: ["bg-background2", "md:prose-xl", "mx-auto", "w-full", "px-6",
                    "prose-img:mx-auto", "prose-img:rounded-xl", "prose-img:shadow-lg"
                ],
                previewRender: (plainText, preview) => {
                    setTimeout(() => {
                        preview.innerHTML =
                            `<div class='container prose dark:prose-invert'>${marked.parse(plainText)}</div>`;
                    }, 250)
                    return "Parsing..."
                },
                hideIcons: ["guide", "side-by-side", "fullscreen"],
                placeholder: "Type here...",
                spellChecker: false,
                promptURLs: true,
                uploadImage: true,
                imageUploadEndpoint: "{{ route('attachment.upload') }}",
                imagePathAbsolute: true,
                imageCSRFToken: "{{ csrf_token() }}",
                imageCSRFName: "_token",
                imageCSRFHeader: true

            });
            easyMDE.value("");
            if (content.dataset.src !== "") {
                let data = axios
                    .get(content.dataset.src)
                    .then((res) => {
                        easyMDE.value(res.data);
                        contentInput.value = res.data;
                        contentInput.dispatchEvent(new Event("input"));
                        return res;
                    })
                    .catch((err) => {
                        console.log(err);
                        return err;
                    });

            }

            easyMDE.codemirror.on("change", () => {
                contentInput.value = easyMDE.value();
                contentInput.dispatchEvent(new Event("input"));
            });
        })
    </script>
</section>
