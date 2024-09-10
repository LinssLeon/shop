document.addEventListener('DOMContentLoaded', function () {
    var dropdowns = document.querySelectorAll('.navbar-nav .dropdown');

    dropdowns.forEach(function (dropdown) {
        var dropdownToggle = dropdown.querySelector('.dropdown-toggle');

        dropdown.addEventListener('mouseover', function () {
            var bsDropdown = new bootstrap.Dropdown(dropdownToggle);
            bsDropdown.show();
            dropdownToggle.classList.add('no-outline');
        });

        dropdown.addEventListener('mouseleave', function () {
            setTimeout(function () {
                var bsDropdown = new bootstrap.Dropdown(dropdownToggle);
                bsDropdown.hide();
            }, 500); // Adjust delay as needed
        });
    });
});

// Add CSS to remove outline
var style = document.createElement('style');
style.innerHTML = `
    .no-outline:focus, .dropdown-toggle:focus {
        outline: none;
        box-shadow: none;
    }
`;
document.head.appendChild(style);