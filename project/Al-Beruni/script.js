document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar")
  const main = document.querySelector("main")
  const sections = document.querySelectorAll(".section")
  const navLinks = document.querySelectorAll(".nav-links a")
  const themeSwitcher = document.querySelector(".theme-switcher")
  const modal = document.getElementById("video-modal")
  const videoButtons = document.querySelectorAll(".video-btn")
  const closeButton = document.querySelector(".close")
  const iframe = document.querySelector(".modal-content iframe")

  // Smooth scrolling
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()
      document.querySelector(this.getAttribute("href")).scrollIntoView({
        behavior: "smooth",
      })
    })
  })

  // Active nav link
  function setActiveNavLink() {
    let current = ""
    sections.forEach((section) => {
      const sectionTop = section.offsetTop
      const sectionHeight = section.clientHeight
      if (pageYOffset >= sectionTop - sectionHeight / 3) {
        current = section.getAttribute("id")

        // Add fade-in class to elements within the current section
        const fadeElements = section.querySelectorAll(".card, h2, p, .teacher-cards, .project-features")
        fadeElements.forEach((el) => {
          if (!el.classList.contains("fade-in")) {
            el.classList.add("fade-in")
            setTimeout(() => el.classList.add("appear"), 100)
          }
        })
      }
    })

    navLinks.forEach((link) => {
      link.classList.remove("active")
      if (link.getAttribute("href").slice(1) === current) {
        link.classList.add("active")
      }
    })
  }

  window.addEventListener("scroll", setActiveNavLink)

  // Theme switcher
  const themes = [
    {
      primary: "#3498db",
      secondary: "#2ecc71",
      background: "#f0f0f0",
      text: "#333",
      card: "#ffffff",
      sidebar: "#2c3e50",
      sidebarText: "#ecf0f1",
    },
    {
      primary: "#e74c3c",
      secondary: "#f39c12",
      background: "#ecf0f1",
      text: "#2c3e50",
      card: "#ffffff",
      sidebar: "#34495e",
      sidebarText: "#ecf0f1",
    },
    {
      primary: "#9b59b6",
      secondary: "#3498db",
      background: "#f3e5f5",
      text: "#4a148c",
      card: "#ffffff",
      sidebar: "#4a148c",
      sidebarText: "#e1bee7",
    },
  ]
  let currentTheme = 0

  themeSwitcher.addEventListener("click", () => {
    currentTheme = (currentTheme + 1) % themes.length
    const theme = themes[currentTheme]
    Object.keys(theme).forEach((key) => {
      document.documentElement.style.setProperty(`--${key}-color`, theme[key])
    })
  })

  // Video modal
  function openModal(videoSrc) {
    iframe.src = videoSrc
    modal.style.display = "block"
    setTimeout(() => modal.classList.add("show"), 10)
  }

  function closeModal() {
    modal.classList.remove("show")
    setTimeout(() => {
      modal.style.display = "none"
      iframe.src = ""
    }, 300)
  }

  videoButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const videoSrc = button.getAttribute("data-video")
      openModal(videoSrc)
    })
  })

  closeButton.addEventListener("click", closeModal)

  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeModal()
    }
  })

  // Responsive sidebar
  function toggleSidebar() {
    sidebar.classList.toggle("open")
    main.style.marginLeft = sidebar.classList.contains("open") ? "250px" : "60px"
  }

  if (window.innerWidth <= 768) {
    sidebar.classList.remove("open")
    main.style.marginLeft = "60px"
  }

  window.addEventListener("resize", () => {
    if (window.innerWidth <= 768) {
      sidebar.classList.remove("open")
      main.style.marginLeft = "60px"
    } else {
      sidebar.classList.add("open")
      main.style.marginLeft = "250px"
    }
  })

  // Scroll animations
  function handleScrollAnimations() {
    const elements = document.querySelectorAll(".fade-in")
    elements.forEach((el) => {
      const rect = el.getBoundingClientRect()
      const windowHeight = window.innerHeight || document.documentElement.clientHeight
      if (rect.top <= windowHeight * 0.75) {
        el.classList.add("appear")
      }
    })
  }

  // Add event listener for scroll animations
  window.addEventListener("scroll", handleScrollAnimations)

  // Initial check for elements in view
  handleScrollAnimations()

  // Initialize
  setActiveNavLink()
})