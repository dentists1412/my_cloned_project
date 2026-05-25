
// 1. HAMBURGER MENU

const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");

if (hamburger && navLinks) {
  hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
  });
}


// 2. CLOSE MENU WHEN LINK CLICKED

const navItems = document.querySelectorAll(".nav-links a");

navItems.forEach(link => {
  link.addEventListener("click", () => {
    if (navLinks) {
      navLinks.classList.remove("active");
    }
  });
});


// 3. HEADER SHADOW ON SCROLL

window.addEventListener("scroll", () => {
  const header = document.querySelector(".header");
  if (header) {
    if (window.scrollY > 50) {
      header.style.boxShadow = "0 5px 10px rgba(0,0,0,0.2)";
    } else {
      header.style.boxShadow = "none";
    }
  }
});


// 4. SMOOTH SCROLL

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener("click", function(e) {
    const targetAttr = this.getAttribute("href");

    if (targetAttr !== '#') {
      const target = document.querySelector(targetAttr);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({
          behavior: "smooth"
        });
      }
    }
  });
});


// 5. GALLERY HOVER EFFECT

const galleryImages = document.querySelectorAll(".gallery-grid img");

galleryImages.forEach(image => {
  image.addEventListener("mouseover", () => {
    image.style.transform = "scale(1.05)";
  });

  image.addEventListener("mouseout", () => {
    image.style.transform = "scale(1)";
  });
});

// 6. LOCAL STORAGE ADMISSION FORM HANDLING
//    (Replaced the old fetch("index.php") section)
const admissionForm = document.querySelector(".admission-form");

if (admissionForm) {
  admissionForm.addEventListener("submit", function (e) {
    // Stop the page from reloading/looking for the PHP server
    e.preventDefault();

    // Automatically grab all inputs inside the HTML form packaging
    const formData = new FormData(this);
    
    // Convert Form Data into a clean JavaScript Object
    const newApplication = {
      id: Date.now(), // Unique ID based on time
      student_name: formData.get("student_name"),
      student_age: formData.get("student_age"),
      class_selection: formData.get("class_selection"),
      old_school_name: formData.get("old_school_name"),
      parent_name: formData.get("parent_name"),
      relationship: formData.get("relationship"),
      parent_email: formData.get("parent_email"),
      message: formData.get("message"),
      submission_date: new Date().toLocaleString()
    };

    // Fetch existing admissions from LocalStorage, or start a new empty list
    let localAdmissions = JSON.parse(localStorage.getItem("divinestar_admissions")) || [];

    // Push the new application entry into our list
    localAdmissions.push(newApplication);

    // Save the updated list back into browser storage
    localStorage.setItem("divinestar_admissions", JSON.stringify(localAdmissions));

    // Notify the user and refresh the inputs
    alert("Application Saved Successfully to Local Storage! (GitHub Mock Database)");
    admissionForm.reset();

    // Log to console so you can see your data updates live
    console.log("Current Local Database Status:", localAdmissions);
  });
}
