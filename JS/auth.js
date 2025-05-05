// Toggle between login and signup forms
function showSignup() {
    const loginBox = document.getElementById('login-box');
    const signupBox = document.getElementById('signup-box');
    
    if (loginBox && signupBox) {
        loginBox.classList.add('hidden');
        signupBox.classList.remove('hidden');
    }
}

function showLogin() {
    const loginBox = document.getElementById('login-box');
    const signupBox = document.getElementById('signup-box');
    
    if (loginBox && signupBox) {
        signupBox.classList.add('hidden');
        loginBox.classList.remove('hidden');
    }
}

// Handle review login triggers
function handleReviewLogin() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('product_id') && !document.querySelector('.user-dropdown-content').classList.contains('active')) {
        // Open login dropdown and show login form
        document.querySelector('.user-dropdown-content').classList.add('active');
        showLogin();
        
        // Scroll to reviews section after login
        const loginForm = document.getElementById('login-box');
        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                sessionStorage.setItem('scrollToReviews', 'true');
            });
        }
    }
}

// Prevent dropdown from closing when clicking inside and handle dropdown toggle
document.addEventListener('DOMContentLoaded', () => {
    const userDropdown = document.querySelector('.user-dropdown');
    const userDropdownContent = document.querySelector('.user-dropdown-content');
    const userIcon = document.querySelector('.fa-user');
    
    if (userDropdown && userDropdownContent && userIcon) {
        // Toggle dropdown when clicking user icon
        userIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdownContent.classList.toggle('active');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userDropdown.contains(e.target)) {
                userDropdownContent.classList.remove('active');
            }
        });
        
        // Prevent dropdown from closing when clicking inside
        userDropdownContent.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
    
    // Check for review login triggers
    handleReviewLogin();
    
    // Handle post-login scroll to reviews
    if (sessionStorage.getItem('scrollToReviews')) {
        sessionStorage.removeItem('scrollToReviews');
        const reviewsSection = document.getElementById('reviews');
        if (reviewsSection) {
            setTimeout(() => {
                reviewsSection.scrollIntoView({ behavior: 'smooth' });
            }, 500); // Small delay to allow page to load
        }
    }
});