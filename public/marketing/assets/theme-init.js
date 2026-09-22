/* Private Deals — light mode only (prevents theme flash) */
(function () {
  try {
    var html = document.documentElement;
    html.classList.remove("dark", "light");
    html.classList.add("light");
    html.dataset.forceTheme = "light";
    localStorage.setItem("color-theme", "light");
  } catch (e) {}

  // Chrome CORS-blocks <link rel="manifest"> on file:// (origin is null).
  // Attach the PWA manifest only when served over http(s).
  try {
    if (location.protocol === "http:" || location.protocol === "https:") {
      var manifest = document.createElement("link");
      manifest.rel = "manifest";
      manifest.href = "./images/favicons/site.webmanifest";
      document.head.appendChild(manifest);
    }
  } catch (e) {}
})();
