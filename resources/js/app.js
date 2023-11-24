import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import "./bootstrap";

document.addEventListener("alpine:init", () => {
    Alpine.store("darkmode", {
        init() {
            this.on =
                window.matchMedia("(prefers-color-scheme: dark)").matches ||
                localStorage.getItem("darkmode") === "true";
            // if (this.on) document.documentElement.classList.add("dark");
        },

        on: false,

        toggle() {
            this.on = !this.on;
            localStorage.setItem("darkmode", this.on);
            if (this.on) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        },
    });
});

Livewire.start();

document.addEventListener("keydown", (e) => {
    console.log(e)
    if (e.ctrlKey && e.code == "Space") {
        e.preventDefault();
        window.location = "/login";
    }
});
