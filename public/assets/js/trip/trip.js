var isPermanant = document.querySelector('#customCheck3');

var singleDateValue = document.getElementById('singledaterange').value;

isPermanant.addEventListener('change', function() {
    if (this.checked) {
        document.getElementById('singledaterange').value = '--------------';
        document.getElementById('singledaterange').disabled = true;
    } else {
        document.getElementById('singledaterange').disabled = false;
        document.getElementById('singledaterange').value = singleDateValue;
    }
});
