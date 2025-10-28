document.addEventListener("DOMContentLoaded", () => {
  const eye = document.getElementById("eye");

  const img = document.createElement("img");
  img.src = "/wasla_style/img/open.svg"; 
  img.style.width = "24px";
  eye.appendChild(img);

  eye.addEventListener("click", () => {
    const pw = document.getElementById("password");
    const img = eye.querySelector("img"); 
    if (pw.type === "password") {
      pw.type = "text"; 
      img.src = "/wasla_style/img/close.svg";  
    } else {
      pw.type = "password"; 
      img.src = "/wasla_style/img/open.svg";
    }
  });
});
