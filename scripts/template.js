window.addEventListener('load', () => {
  let uuid = getUid();

  if (uuid == "" || uuid == null || uuid == undefined) {
    uuid = generateUID();

    localStorage.setItem('webPosUid', uuid);
  }
});


$('.search').keyup(function (e) {
  if (e.key === 'Enter') {
    getSearch();
  }
});


$('.filter').change(function () {
  getSearch();
});


const inputRows = document.getElementById('set-rows');

if (inputRows) {
  inputRows.addEventListener('keyup', (e) => {
    if (e.key === 'Enter') {
      setRows();
    }
  });
}

const generateUID = (length = 15) => {
  const array = new Uint8Array(length);
  crypto.getRandomValues(array);
  return Array.from(array, v => v.toString(36)).join('');
};


const getUid = () => {
  return localStorage.getItem('webPosUid');
}


const goBack = () => {
  window.location.href = HOME;
}


const getSearch = () => {
  $('#search-form').submit();
}


const clearFilter = () => {
  fetch(`${HOME}clear_filter`)
    .then(() => {
      goBack();
    })
    .catch(err => console.error(err));
};


const toggleLayout = () => {
  const sidebarLayout = getCookie('sidebar_layout');
  const newValue = sidebarLayout === 'menu-min' ? '' : 'menu-min';
  setCookie('sidebar_layout', newValue, 90);
};


const loadIn = (text = '') => {
  const loader = document.getElementById('loader');
  const backdrop = document.getElementById('loader-backdrop');
  const loaderText = document.querySelector('.loader-text');

  loaderText.textContent = text;

  loader.classList.add('show');
  backdrop.classList.add('show');
};


const loadOut = () => {
  const loader = document.getElementById('loader');
  const backdrop = document.getElementById('loader-backdrop');

  loader.classList.remove('show');
  backdrop.classList.remove('show');

  const onTransitionEnd = () => {
    loader.removeEventListener('transitionend', onTransitionEnd);
  };

  loader.addEventListener('transitionend', onTransitionEnd, { once: true });
};


const load_in = (text = '') => {
  return loadIn(text);
}


const load_out = () => {
  return loadOut();
}


const createDateValidator = (defaultLocale = "th-TH") => {
  const localeFormats = {
    "th-TH": ["DD", "MM", "YYYY"],
    "en-GB": ["DD", "MM", "YYYY"],
    "en-US": ["MM", "DD", "YYYY"],
    "ja-JP": ["YYYY", "MM", "DD"],
    "iso": ["YYYY", "MM", "DD"]
  };

  const getFormat = (locale) => localeFormats[locale] || localeFormats[defaultLocale];

  const isValidDate = (input, locale = defaultLocale) => {
    if (!input) return false;

    const separators = ["/", "-", ".", " "];
    const sep = separators.find(s => input.includes(s));
    if (!sep) return false;

    const parts = input.split(sep);
    const format = getFormat(locale);
    if (parts.length !== 3) return false;

    const map = {};
    format.forEach((key, i) => map[key] = Number(parts[i]));

    const day = map["DD"];
    const month = map["MM"];
    const year = map["YYYY"];

    if (!day || !month || !year) return false;
    if (month < 1 || month > 12) return false;
    if (day < 1 || day > 31) return false;
    if ([4, 6, 9, 11].includes(month) && day === 31) return false;

    if (month === 2) {
      const leap = (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0));
      if (day > 29 || (day === 29 && !leap)) return false;
    }

    return true;
  };

  return { isValidDate };
};


const isDate = (date, local) => {
  const validator = createDateValidator(local);
  return validator.isValidDate(date, local);
}


const removeCommas = (str) => String(str).split(',').join('');


const addCommas = (number) => {
  const str = typeof number === 'number' ? number.toString() : number;
  const [intPart, decimalPart] = str.split('.');

  const insertCommas = (digits) => {
    let result = '';
    let count = 0;

    for (let i = digits.length - 1; i >= 0; i--) {
      result = digits[i] + result;
      count++;
      if (count === 3 && i !== 0) {
        result = ',' + result;
        count = 0;
      }
    }
    return result;
  };

  const formattedInt = insertCommas(intPart.replace(/^([-+])/, ''));
  const sign = intPart.startsWith('-') ? '-' : intPart.startsWith('+') ? '+' : '';

  return decimalPart ? `${sign}${formattedInt}.${decimalPart}` : `${sign}${formattedInt}`;
};


const render = (source, data, output) => {
  const template = Handlebars.compile(source);
  const html = template(data);
  output.html(html);
}


const renderPrepend = (source, data, output) => {
  const template = Handlebars.compile(source);
  const html = template(data);
  output.prepend(html);
}


const renderAppend = (source, data, output) => {
  const template = Handlebars.compile(source);
  const html = template(data);
  output.append(html);
}


const renderAfter = (source, data, output) => {
  const template = Handlebars.compile(source);
  const html = template(data);
  $(html).insertAfter(output);
};


const renderBefore = (source, data, output) => {
  const template = Handlebars.compile(source);
  const html = template(data);
  $(html).insertBefore(output);
};


const setRows = () => {
  const rows = document.getElementById('set-rows');

  fetch(`${BASE_URL}tools/set_rows`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
      set_rows: rows.value
    })
  })
    .then(() => {
      window.location.reload();
    })
    .catch(err => console.error(err));
};


const reIndex = (className = 'no') => {
  const elements = document.querySelectorAll(`.${className}`);

  elements.forEach((el, index) => {
    const no = index + 1;
    el.textContent = addCommas(no);
  });
};


let downloadTimer;

const getDownload = (token) => {
  loadIn();

  downloadTimer = setInterval(() => {
    const cookie = getCookie("file_download_token");
    if (cookie === token) {
      finishedDownload();
    }
  }, 1000);
};


const finishedDownload = () => {
  clearInterval(downloadTimer);
  deleteCookie("file_download_token");
  loadOut();
};


const isJson = (str) => {
  try {
    JSON.parse(str);
    return true;
  } catch {
    return false;
  }
};


const printOut = (url, width = 800, height = 900) => {
  const left = (window.screen.width - width) / 2;
  const top = (window.screen.height - height) / 2;

  window.open(url, "_blank", `width=${width},height=${height},left=${left},top=${top},scrollbars=yes`);
};


const setCookie = (name, value, days) => {
  const d = new Date();
  d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
  const expires = `expires=${d.toUTCString()}`;
  document.cookie = `${name}=${value};${expires};path=/`;
};


const getCookie = (name) => {
  const target = `${name}=`;
  const cookies = document.cookie.split(";");

  for (let c of cookies) {
    c = c.trim();
    if (c.startsWith(target)) {
      return c.substring(target.length);
    }
  }

  return "";
};

const deleteCookie = (name) => {
  document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/`;
};


const parseDefault = (value, def) => {
  return isNaN(value) ? def : value;
};


const parseDefaultInt = (value, def) => {
  const val = parseInt(value);
  return isNaN(val) ? def : val;
};


const parseDefaultFloat = (value, def) => {
  const val = parseFloat(value);
  return isNaN(val) ? def : val;
};


const roundNumber = (num, digit = 2) => {
  const d = parseDefaultInt(digit, 2);
  return Number(parseFloat(num).toFixed(d));
};


const parseDiscountPercent = (price, discAmount) => {
  if (price > 0 && discAmount > 0 && price > discAmount) {
    return (discAmount / price) * 100;
  }

  return 0.0;
};


const parseDiscountAmount = (discountLabel, price) => {
  let discAmount = 0;
  let basePrice = price;

  if (discountLabel && discountLabel !== "0") {
    const parts = discountLabel.split("+");

    parts.forEach((item, index) => {
      if (index < 3) {
        const [rawValue, percentSign] = item.split("%");
        const value = parseDefault(parseFloat(rawValue), 0);

        if (percentSign !== undefined) {
          const currentPrice = price === 0 ? basePrice : price;
          const amount = (value / 100) * currentPrice;
          discAmount += amount;
          price -= amount;
        } else {
          discAmount += value;
          price -= value;
        }
      }
    });
  }

  return discAmount;
};


const parseDiscount = (discountLabel, price) => {
  const result = {
    discLabel1: 0,
    discUnit1: '',
    discLabel2: 0,
    discUnit2: '',
    discLabel3: 0,
    discUnit3: '',
    discountAmount: 0,
    finalPrice: price,
    discountPercent: 0
  };

  if (discountLabel && discountLabel !== '0') {
    const parts = discountLabel.split('+');
    let currentPrice = price;

    parts.forEach((item, index) => {
      if (index < 3) {
        const [rawValue, percentSign] = item.split('%');
        const value = parseDefault(parseFloat(rawValue), 0);
        const labelKey = `discLabel${index + 1}`;
        const unitKey = `discUnit${index + 1}`;

        result[labelKey] = value;

        if (percentSign !== undefined) {
          const amount = (value / 100) * currentPrice;
          result[unitKey] = '%';
          result.discountAmount += amount;
          currentPrice -= amount;
        } else {
          result.discountAmount += value;
          currentPrice -= value;
        }
      }
    });

    result.finalPrice = currentPrice;
    result.discountPercent = price > 0 ? (result.discountAmount / price) * 100 : 0;
  }

  return result;
};


const sort = (field) => {
  const el = document.getElementById(`sort-${field}`);
  const isDesc = el.classList.contains('sorting_desc');
  const sortBy = isDesc ? 'ASC' : 'DESC';
  const sortClass = isDesc ? 'sorting_asc' : 'sorting_desc';

  document.querySelectorAll('.sorting').forEach(item => {
    item.classList.remove('sorting_desc', 'sorting_asc');
  });

  el.classList.add(sortClass);

  document.getElementById('sort_by').value = sortBy;
  document.getElementById('order_by').value = field;

  getSearch();
};


const getDeviceId = () => {
  const deviceId = localStorage.getItem('DeviceId');

  if (!deviceId) {
    deviceId = generateUID();
    localStorage.setItem('DeviceId', deviceId);
  }

  return deviceId;
}


const validInput = (input, regex = /[^a-zA-Z0-9-_.@]+/gi) => {
  input.value = input.value.replace(regex, '');
};


const numberOnly = (input) => {
  const regex = /[^0-9]+/gi;
  input.value = input.value.replace(regex, '');
};


const closeModal = (modalName) => {
  $(`#${modalName}`).modal('hide');
};


const getVatAmount = (amount, rate, type) => {
  let vatAmount = 0.00;

  amount = parseDefault(parseFloat(amount), 0.00);
  rate = parseDefault(parseFloat(rate), 0.00);

  if (amount > 0 && rate > 0 && type !== 'N') {
    const vatRate = type === 'I'
      ? (rate + 100) * 0.01
      : rate * 0.01;

    vatAmount = type === 'I'
      ? amount - (amount / vatRate)
      : amount * vatRate;
  }

  return vatAmount;
};

const addVat = (amount, rate, type) => {
  amount = parseDefault(parseFloat(amount), 0.00);
  rate = parseDefault(parseFloat(rate), 0.00);

  return type === 'E'
    ? amount + (amount * rate)
    : amount;
};

const removeVat = (amount, rate, type) => {
  amount = parseDefault(parseFloat(amount), 0.00);
  rate = parseDefault(parseFloat(rate), 0.00);

  if (amount > 0 && rate > 0 && type !== 'N') {
    const vatRate = (rate + 100) * 0.01;
    amount = amount / vatRate;
  }

  return amount;
};


const parseAddress = (addr, subDistrict, district, province, postcode) => {
  const pv = parseProvince(province);
  const sd = parseSubDistrict(subDistrict, pv);
  const dt = parseDistrict(district, pv);

  return `${addr} ${sd} ${dt} ${pv} ${postcode}`;
};


const isBangkok = (province) => {
  const p = province?.replace(/\s+/g, '');
  const list = [
    'จ.กรุงเทพมหานคร', 'จังหวัดกรุงเทพมหานคร', 'กรุงเทพ',
    'กรุงเทพฯ', 'กรุงเทพมหานคร', 'กทม', 'กทม.', 'ก.ท.ม.'
  ];
  return list.includes(p);
};


const parseSubDistrict = (ad, province) => {
  if (!ad) return ad;

  let clean = ad.replace(/\s+/g, '').replace('แขวง', '').replace('ต.', '').replace('ตำบล', '');

  return isBangkok(province)
    ? `แขวง${clean}`
    : `ต. ${clean}`;
};


const parseDistrict = (ad, province) => {
  if (!ad) return ad;

  let clean = ad.replace(/\s+/g, '').replace('เขต', '').replace('อ..', '').replace('อำเภอ', '');

  return isBangkok(province)
    ? `เขต${clean}`
    : `อ. ${clean}`;
};


const parseProvince = (ad) => {
  if (!ad) return ad;

  let clean = ad.replace(/\s+/g, '').replace('จ.', '').replace('จังหวัด', '');

  if (['กรุงเทพ', 'กรุงเทพฯ', 'กรุงเทพมหานคร', 'กทม', 'กทม.', 'ก.ท.ม.'].includes(clean)) {
    clean = 'กรุงเทพมหานคร';
  }

  return `จ. ${clean}`;
};


const hilightRow = (id) => {
  document.querySelectorAll('.order-rows').forEach(row => {
    row.classList.remove('active-row');
  });

  const target = document.getElementById(`row-${id}`);
  if (target) {
    target.classList.add('active-row');
  }
};


async function postData(url, data) {
  return fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  });
}



async function validateRemote(url, data = {}) {
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    });

    return (await response.text()).trim();
  } catch (err) {
    console.error('Validation error:', err);
    return 'error';
  }
}

$.fn.hasError = function (msg) {
  let name = this.attr('id');
  $('#' + name + '-error').text(msg);
  return this.addClass('has-error');
};

$.fn.clearError = function () {
  this.removeClass('has-error');
  let name = this.attr('id');
  return $('#' + name + '-error').text('');
};


const clearErrorByClass = (className) => {
  const elements = document.querySelectorAll(`.${className}`);

  elements.forEach(el => {
    const name = el.id;
    const errorEl = document.getElementById(`${name}-error`);

    if (errorEl) {
      errorEl.textContent = '';
    }

    el.classList.remove('has-error');
  });
};


const showError = (response) => {
  loadOut();

  setTimeout(() => {
    swal({
      title: 'Error!',
      text: typeof response === 'object' ? response.responseText : response,
      type: 'error',
      html: true
    });
  }, 100);
};


function setError(input, errorBox, message) {
  errorBox.textContent = message;
  input.classList.add('has-error');
}

function clearError(input, errorBox) {
  errorBox.textContent = '';
  input.classList.remove('has-error');
}

const is_true = (val) => {
  if (typeof val === 'string') {
    val = val.trim().toLowerCase();
  }

  const truthy = ["true", "1", "yes", "y", "on"];
  return val === true || val === 1 || truthy.includes(val);
};