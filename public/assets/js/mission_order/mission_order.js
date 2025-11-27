var isPermanant = document.querySelector('#customCheck3');

var singleDateValue = document.getElementById('end_date').value;

isPermanant.addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('end_date').value = '--------------';
        document.getElementById('end_date').disabled = true;
    } else {
        document.getElementById('end_date').disabled = false;
        document.getElementById('end_date').value = singleDateValue;
    }
});

