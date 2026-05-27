// 1. HAMBURGER MENU
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");

if (hamburger && navLinks) {
  hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
  });
}


// 2. CLOSE MENU WHEN LINK CLICKED
const navItems = document.querySelectorAll("#nav-links a");

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

const admissionForm = document.querySelector(".admission-form");

if (admissionForm) {
  admissionForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    const newApplication = {
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

    // Fix: Make sure it ends exactly at 'admissions' with no generic tags!
    const CLOUD_API_URL = "https://6a15251e91ff9a63de078780.mockapi.io/admissions";

    fetch(CLOUD_API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(newApplication)
    })
    .then(response => {
      if (!response.ok) throw new Error("Network issue");
      return response.json();
    })
    .then(data => {
      alert("Application Submitted & Saved to Cloud Successfully!");
      admissionForm.reset();
    })
    .catch(error => {
      console.error("Submission error:", error);
      alert("Failed to submit application. Please check your internet connection.");
    });
  });
}
