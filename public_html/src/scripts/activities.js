const params = {
    offset: 1,
    type: null,
    institute: null,
    age_from: null,
    age_to: null,
    amount_from: null,
    amount_to: null,
    price_from: null,
    price_to: null,
    duration_from: null,
    duration_to: null,
    price_month_from: null,
    price_month_to: null,
    search: null,
    order_by: 'id',
    order: 'ASC'
}

let typeSelector = document.querySelector('.js-order-by-type');
let instituteSelector = document.querySelector('.js-order-by-institute');
let search = document.querySelector('.is-input-search');
let orderBy = document.querySelector('.js-order-by-fields');

let order = document.querySelector('.js-order-items');

order.addEventListener('click', (e) => {
    if (params.order === 'ASC') {
        params.order = 'DESC';
    } else {
        params.order = 'ASC';
    }
    params.offset = 0;
    e.target.classList.toggle("checked")
    loadData(params, true);
})

search.addEventListener('input', (e) => {
    params.offset = 0;
    if (e.target.value.length >= 3) {
        params.search = search.value
        loadData(params, true);
    } else {
        params.search = null
        loadData(params, true);
    }
})

orderBy.addEventListener('change', (e) => {
    params.offset = 0;
    params.order_by = e.target.value;
    loadData(params, true);
})

instituteSelector.addEventListener('change', (e) => {
    params.offset = 0;
    params.institute = e.target.value;
    loadData(params, true);
})

typeSelector.addEventListener('change', (e) => {
    params.offset = 0;
    params.type = e.target.value;
    loadData(params, true);
})

window.addEventListener('scroll', () => {
    const {
        scrollTop,
        scrollHeight,
        clientHeight
    } = document.documentElement;

    if (scrollTop + clientHeight >= scrollHeight) {
        params.offset = document.querySelectorAll('.activity_card').length;
        loadData(params);
    }
}, {
    passive: true
});


let cardListMobile = document.querySelector('.card_list')
let cardList = document.querySelector('.activity_list_rows')

function loadData(params, is_search) {
    document.getElementById('spinner').classList.add('loader__active')
    document.querySelector('.loader').classList.add('loader__active')
    let url = "/activities/index?";
    let query = Object.keys(params)
        .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
        .join('&');
    fetch(url + query, {method: 'get', credentials: 'same-origin', headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (is_search) {
                cardListMobile.innerHTML = data.html_mobile;
                cardList.innerHTML = data.html;
            } else {
                cardListMobile.innerHTML += data.html_mobile;
                cardList.innerHTML += data.html;
            }
        })
        .finally(() => {
            document.getElementById('spinner').classList.remove('loader__active')
            document.querySelector('.loader').classList.remove('loader__active')
        })
}

mybutton = document.getElementById("buttonToTop");

window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

var inputLeftAmount = document.getElementById("input-left-amount");
var inputRightAmount = document.getElementById("input-right-amount");

var thumbLeftAmount = document.querySelector(".slider-amount > .thumb.left");
var thumbRightAmount = document.querySelector(".slider-amount > .thumb.right");
var rangeAmount = document.querySelector(".slider-amount > .range");

function setLeftValueAmount() {
    var _this = inputLeftAmount,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.min(parseInt(_this.value), parseInt(inputRightAmount.value) - 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbLeftAmount.style.left = percent + "%";
    rangeAmount.style.left = percent + "%";
}

setLeftValueAmount();

function setRightValueAmount() {
    var _this = inputRightAmount,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.max(parseInt(_this.value), parseInt(inputLeftAmount.value) + 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbRightAmount.style.right = (100 - percent) + "%";
    rangeAmount.style.right = (100 - percent) + "%";
}

setRightValueAmount();

inputLeftAmount.addEventListener("input", setLeftValueAmount);
inputRightAmount.addEventListener("input", setRightValueAmount);

inputLeftAmount.addEventListener("mouseover", function () {
    thumbLeftAmount.classList.add("hover");
});
inputLeftAmount.addEventListener("mouseout", function () {
    thumbLeftAmount.classList.remove("hover");
});
inputLeftAmount.addEventListener("mousedown", function () {
    thumbLeftAmount.classList.add("active");
});
inputLeftAmount.addEventListener("mouseup", function () {
    thumbLeftAmount.classList.remove("active");
});

inputRightAmount.addEventListener("mouseover", function () {
    thumbRightAmount.classList.add("hover");
});
inputRightAmount.addEventListener("mouseout", function () {
    thumbRightAmount.classList.remove("hover");
});
inputRightAmount.addEventListener("mousedown", function () {
    thumbRightAmount.classList.add("active");
});
inputRightAmount.addEventListener("mouseup", function () {
    thumbRightAmount.classList.remove("active");
});

var inputLeftDuration = document.getElementById("input-left-duration");
var inputRightDuration = document.getElementById("input-right-duration");

var thumbLeftDuration = document.querySelector(".slider-duration > .thumb.left");
var thumbRightDuration = document.querySelector(".slider-duration > .thumb.right");
var rangeDuration = document.querySelector(".slider-duration > .range");

function setLeftValueDuration() {
    var _this = inputLeftDuration,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.min(parseInt(_this.value), parseInt(inputRightDuration.value) - 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbLeftDuration.style.left = percent + "%";
    rangeDuration.style.left = percent + "%";
}

setLeftValueDuration();

function setRightValueDuration() {
    var _this = inputRightDuration,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.max(parseInt(_this.value), parseInt(inputLeftDuration.value) + 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbRightDuration.style.right = (100 - percent) + "%";
    rangeDuration.style.right = (100 - percent) + "%";
}

setRightValueDuration();

inputLeftDuration.addEventListener("input", setLeftValueDuration);
inputRightDuration.addEventListener("input", setRightValueDuration);

inputLeftDuration.addEventListener("mouseover", function () {
    thumbLeftDuration.classList.add("hover");
});
inputLeftDuration.addEventListener("mouseout", function () {
    thumbLeftDuration.classList.remove("hover");
});
inputLeftDuration.addEventListener("mousedown", function () {
    thumbLeftDuration.classList.add("active");
});
inputLeftDuration.addEventListener("mouseup", function () {
    thumbLeftDuration.classList.remove("active");
});

inputRightDuration.addEventListener("mouseover", function () {
    thumbRightDuration.classList.add("hover");
});
inputRightDuration.addEventListener("mouseout", function () {
    thumbRightDuration.classList.remove("hover");
});
inputRightDuration.addEventListener("mousedown", function () {
    thumbRightDuration.classList.add("active");
});
inputRightDuration.addEventListener("mouseup", function () {
    thumbRightDuration.classList.remove("active");
});

var inputLeftPriceMonth = document.getElementById("input-left-price-month");
var inputRightPriceMonth = document.getElementById("input-right-price-month");

var thumbLeftPriceMonth = document.querySelector(".slider-price-month > .thumb.left");
var thumbRightPriceMonth = document.querySelector(".slider-price-month > .thumb.right");
var rangePriceMonth = document.querySelector(".slider-price-month > .range");

function setLeftValuePriceMonth() {
    var _this = inputLeftPriceMonth,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.min(parseInt(_this.value), parseInt(inputRightPriceMonth.value) - 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbLeftPriceMonth.style.left = percent + "%";
    rangePriceMonth.style.left = percent + "%";
}

setLeftValuePriceMonth();

function setRightValuePriceMonth() {
    var _this = inputRightPriceMonth,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.max(parseInt(_this.value), parseInt(inputLeftPriceMonth.value) + 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbRightPriceMonth.style.right = (100 - percent) + "%";
    rangePriceMonth.style.right = (100 - percent) + "%";
}

setRightValuePriceMonth();

inputLeftPriceMonth.addEventListener("input", setLeftValuePriceMonth);
inputRightPriceMonth.addEventListener("input", setRightValuePriceMonth);

inputLeftPriceMonth.addEventListener("mouseover", function () {
    thumbLeftPriceMonth.classList.add("hover");
});
inputLeftPriceMonth.addEventListener("mouseout", function () {
    thumbLeftPriceMonth.classList.remove("hover");
});
inputLeftPriceMonth.addEventListener("mousedown", function () {
    thumbLeftPriceMonth.classList.add("active");
});
inputLeftPriceMonth.addEventListener("mouseup", function () {
    thumbLeftPriceMonth.classList.remove("active");
});

inputRightPriceMonth.addEventListener("mouseover", function () {
    thumbRightPriceMonth.classList.add("hover");
});
inputRightPriceMonth.addEventListener("mouseout", function () {
    thumbRightPriceMonth.classList.remove("hover");
});
inputRightPriceMonth.addEventListener("mousedown", function () {
    thumbRightPriceMonth.classList.add("active");
});
inputRightPriceMonth.addEventListener("mouseup", function () {
    thumbRightPriceMonth.classList.remove("active");
});
var inputLeftPrice = document.getElementById("input-left-price");
var inputRightPrice = document.getElementById("input-right-price");

var thumbLeftPrice = document.querySelector(".slider-price > .thumb.left");
var thumbRightPrice = document.querySelector(".slider-price > .thumb.right");
var rangePrice = document.querySelector(".slider-price > .range");

function setLeftValuePrice() {
    var _this = inputLeftPrice,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.min(parseInt(_this.value), parseInt(inputRightPrice.value) - 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbLeftPrice.style.left = percent + "%";
    rangePrice.style.left = percent + "%";
}

setLeftValuePrice();

function setRightValuePrice() {
    var _this = inputRightPrice,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.max(parseInt(_this.value), parseInt(inputLeftPrice.value) + 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbRightPrice.style.right = (100 - percent) + "%";
    rangePrice.style.right = (100 - percent) + "%";
}

setRightValuePrice();

inputLeftPrice.addEventListener("input", setLeftValuePrice);
inputRightPrice.addEventListener("input", setRightValuePrice);

inputLeftPrice.addEventListener("mouseover", function () {
    thumbLeftPrice.classList.add("hover");
});
inputLeftPrice.addEventListener("mouseout", function () {
    thumbLeftPrice.classList.remove("hover");
});
inputLeftPrice.addEventListener("mousedown", function () {
    thumbLeftPrice.classList.add("active");
});
inputLeftPrice.addEventListener("mouseup", function () {
    thumbLeftPrice.classList.remove("active");
});

inputRightPrice.addEventListener("mouseover", function () {
    thumbRightPrice.classList.add("hover");
});
inputRightPrice.addEventListener("mouseout", function () {
    thumbRightPrice.classList.remove("hover");
});
inputRightPrice.addEventListener("mousedown", function () {
    thumbRightPrice.classList.add("active");
});
inputRightPrice.addEventListener("mouseup", function () {
    thumbRightPrice.classList.remove("active");
});


var inputLeft = document.getElementById("input-left");
var inputRight = document.getElementById("input-right");

var thumbLeft = document.querySelector(".slider > .thumb.left");
var thumbRight = document.querySelector(".slider > .thumb.right");
var range = document.querySelector(".slider > .range");

function setLeftValue() {
    var _this = inputLeft,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.min(parseInt(_this.value), parseInt(inputRight.value) - 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbLeft.style.left = percent + "%";
    range.style.left = percent + "%";
}

setLeftValue();

function setRightValue() {
    var _this = inputRight,
        min = parseInt(_this.min),
        max = parseInt(_this.max);

    _this.value = Math.max(parseInt(_this.value), parseInt(inputLeft.value) + 1);

    var percent = ((_this.value - min) / (max - min)) * 100;

    thumbRight.style.right = (100 - percent) + "%";
    range.style.right = (100 - percent) + "%";
}

setRightValue();

inputLeft.addEventListener("input", setLeftValue);
inputRight.addEventListener("input", setRightValue);

inputLeft.addEventListener("mouseover", function () {
    thumbLeft.classList.add("hover");
});
inputLeft.addEventListener("mouseout", function () {
    thumbLeft.classList.remove("hover");
});
inputLeft.addEventListener("mousedown", function () {
    thumbLeft.classList.add("active");
});
inputLeft.addEventListener("mouseup", function () {
    thumbLeft.classList.remove("active");
});

inputRight.addEventListener("mouseover", function () {
    thumbRight.classList.add("hover");
});
inputRight.addEventListener("mouseout", function () {
    thumbRight.classList.remove("hover");
});
inputRight.addEventListener("mousedown", function () {
    thumbRight.classList.add("active");
});
inputRight.addEventListener("mouseup", function () {
    thumbRight.classList.remove("active");
});