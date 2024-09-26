document.getElementById('edit-button').addEventListener('click', function () {
    var inputs = document.querySelectorAll('input[readonly]');
    inputs.forEach(function (input) {
        input.removeAttribute('readonly');
        input.classList.remove('bg-gray-200');
        input.classList.add('bg-white');
    });
    document.getElementById('edit-button').style.display = 'none';
    document.getElementById('save-button').style.display = 'inline-block';
});