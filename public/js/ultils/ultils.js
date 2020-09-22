export function download(file, fileName) {
    const url = window.URL.createObjectURL(new Blob([file]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", fileName); //or any other extension
    document.body.appendChild(link);
    link.click();
}
