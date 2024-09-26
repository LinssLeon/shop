// public/js/dropdown.js

document.addEventListener('DOMContentLoaded', function () {
    const shopDropdownToggle = document.getElementById('shopDropdownToggle');
    const shopDropdownMenu = document.getElementById('shopDropdownMenu');
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');

    shopDropdownToggle.addEventListener('click', function () {
        shopDropdownMenu.classList.toggle('hidden');
    });

    userDropdownToggle.addEventListener('click', function () {
        userDropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function (event) {
        if (!shopDropdownToggle.contains(event.target) && !shopDropdownMenu.contains(event.target)) {
            shopDropdownMenu.classList.add('hidden');
        }
        if (!userDropdownToggle.contains(event.target) && !userDropdownMenu.contains(event.target)) {
            userDropdownMenu.classList.add('hidden');
        }
    });
});