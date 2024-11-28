/**
     * Supported file formats and their associated icons.
     */
const supportedFormats = [
  { name: 'PNG', icon: './assets/images/png.png' },
  { name: 'JPG', icon: './assets/images/jpg.png' },
  { name: 'JPEG', icon: './assets/images/jpeg.png' },
  { name: 'PSD', icon: './assets/images/psd.png' },
  { name: 'GIF', icon: './assets/images/gif.png' },
  { name: 'BMP', icon: './assets/images/bmp.png' }
];

/**
 * Create a list item for each supported file format.
 *
 * @param {Object} format - The format object containing name and icon.
 * @returns {string} HTML string for the list item.
 */
function createFormatListItem(format) {
  return `
<li class="list-group-item d-flex gap-2 align-items-center">
  <img src="${format.icon}" alt="Icon ${format.name}" style="height: 32px;aspect-ratio: 1/1">
  <span><code>File ${format.name}</code></span>
</li>
`;
}

/**
 * Convert a Base64 string to a Blob and trigger a file download.
 *
 * @param {string} base64String - The Base64 encoded string.
 * @param {string} mimeType - The mime type of the file.
 * @param {string} fileName - The name of the file to be downloaded.
 */
function base64ToFile(base64String, mimeType, fileName) {
  const base64Data = base64String.replace(/^data:.+;base64,/, '');
  const byteCharacters = atob(base64Data);
  const byteNumbers = new Array(byteCharacters.length);
  for (let i = 0; i < byteCharacters.length; i++) {
    byteNumbers[i] = byteCharacters.charCodeAt(i);
  }
  const byteArray = new Uint8Array(byteNumbers);
  const blob = new Blob([byteArray], { type: mimeType });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.download = fileName;
  link.click();
  URL.revokeObjectURL(url);
}


document.getElementById('download-file').addEventListener('click', function () {
  const base64Data = this.getAttribute('data-base64');
  const mimeType = this.getAttribute('data-mime') || 'image/jpeg';
  const date = new Date().toISOString().slice(0, 10).replace(/-/g, '-');
  const fileName = `decrypted_file-${date}.${mimeType.split('/')[1]}`;
  if (base64Data) {
    try {
      atob(base64Data);
      base64ToFile(`data:${mimeType};base64,${base64Data}`, mimeType, fileName);
    } catch (error) {
      alert('Data base64 tidak valid. Gagal mengunduh.');
      console.error('Base64 Download Error:', error);
    }
  } else {
    alert('Tidak ada file yang dapat diunduh.');
  }
});


const midPoint = Math.ceil(supportedFormats.length / 2);
document.getElementById('format-list-1').innerHTML = supportedFormats
  .slice(0, midPoint)
  .map(createFormatListItem)
  .join('');
document.getElementById('format-list-2').innerHTML = supportedFormats
  .slice(midPoint)
  .map(createFormatListItem)
  .join('');


document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('.needs-validation');

  const fileInputs = document.querySelectorAll('input[type="file"][data-max-size]');
  fileInputs.forEach(input => {
    input.addEventListener('change', function () {
      validateFileSize(this);
    });
  });

  forms.forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      } else {
        if (form.id === 'post-encrypt') {
          validateFile(event, form);
          doUploadEncrypt(event);
        } else if (form.id === 'post-decrypt') {
          doUploadDecrypt(event);
        }
      }
      form.classList.add('was-validated');
    });
  });
});

/**
 * Handle file encryption upload via AJAX.
 *
 * @param {Event} event - The form submission event.
 */
function doUploadEncrypt(event) {
  event.preventDefault();
  const form = event.target;
  const formData = new FormData(form);
  formData.append("type", "encrypt");

  $.ajax({
    url: './process.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () {
      $('#iv-result').val('');
      $('#resultEncrypted').toggle(false);
      $('#download-link').attr('href', ``);
      $(form).find('button').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
      $(form).find('button').attr('disabled', true);
    },
    success: function (data) {
      const result = data.data;
      $('#resultEncrypted').toggle(!!result.iv);
      $('#iv-result').val(`${result.iv},${result.extension}`);
      $('#download-link').attr('href', `./download.php?filename=${result.fileName}`);
      $(form).find('button').html('Enkripsi');
      $(form).find('button').removeAttr('disabled');
    },
    error: function (error) {
      console.log(error);
      $('#iv-result').val('');
      $('#resultEncrypted').toggle(false);
      $('#download-link').attr('href', ``);
      $(form).find('button').html('Enkripsi');
      $(form).find('button').removeAttr('disabled');
    }
  });
}

/**
 * Handle file decryption upload via AJAX.
 *
 * @param {Event} event - The form submission event.
 */
function doUploadDecrypt(event) {
  event.preventDefault();
  const form = event.target;

  const ivInput = form.querySelector('#iv');
  if (!ivInput.value.trim()) {
    ivInput.classList.add('is-invalid');
    ivInput.setCustomValidity('Kunci enkripsi tidak boleh kosong');
    ivInput.reportValidity();
    return;
  }

  const fileInput = form.querySelector('input[type="file"]');
  const file = fileInput.files[0];
  if (!file) {
    fileInput.classList.add('is-invalid');
    fileInput.setCustomValidity('Harap pilih file untuk didekripsi');
    fileInput.reportValidity();
    return;
  }

  const fileName = file.name.toLowerCase();
  if (!fileName.endsWith('.enc')) {
    fileInput.classList.add('is-invalid');
    fileInput.setCustomValidity('Hanya file dengan ekstensi .enc yang diperbolehkan');
    fileInput.reportValidity();
    return;
  }

  const maxSize = parseInt(fileInput.dataset.maxSize);
  if (file.size > maxSize) {
    fileInput.classList.add('is-invalid');
    fileInput.setCustomValidity(`Ukuran file terlalu besar. Maksimal ukuran file adalah ${(maxSize / (1024 * 1024)).toFixed()}MB`);
    fileInput.reportValidity();
    return;
  }

  const formData = new FormData(form);
  formData.append("type", "decrypt");

  $.ajax({
    url: './process.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () {
      ivInput.classList.remove('is-invalid');
      fileInput.classList.remove('is-invalid');
      $('#resultDecrypted').toggle(false);
      $('#img-result').attr('src', '');
      $(form).find('button').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
      $(form).find('button').attr('disabled', true);
    },
    success: function (data) {
      const result = data.data;
      if (result && result.result) {
        $('#resultDecrypted').toggle(true);
        $('#img-result').attr('src', `data:image/${result.extension ?? 'jpeg'};base64,${result.result}`);
        const base64Data = result.result;
        const mimeType = result.extension ? `image/${result.extension}` : 'image/jpeg';
        $('#download-file').attr('data-base64', base64Data);
        $('#download-file').attr('data-mime', mimeType);
      } else {
        alert('Dekripsi gagal. Pastikan kunci dan file enkripsi benar.');
      }
      $(form).find('button').html('Dekripsi');
      $(form).find('button').removeAttr('disabled');
    },
    error: function (error) {
      console.error(error);
      alert('Terjadi kesalahan dalam proses dekripsi. Silakan coba lagi.');
      $('#resultDecrypted').toggle(false);
      $('#img-result').attr('src', '');
      $(form).find('button').html('Dekripsi');
      $(form).find('button').removeAttr('disabled');
    }
  });
}

/**
 * Validate the file size of an input element.
 *
 * @param {HTMLInputElement} input - The file input element.
 * @returns {boolean} True if the file size is valid, false otherwise.
 */
function validateFileSize(input) {
  const maxSize = parseInt(input.dataset.maxSize);
  const file = input.files[0];
  input.classList.remove('is-invalid');
  const feedback = input.nextElementSibling;
  if (file && file.size > maxSize) {
    input.value = '';
    input.classList.add('is-invalid');
    feedback.textContent = `Ukuran file terlalu besar. Maksimal ukuran file adalah ${(maxSize / (1024 * 1024)).toFixed()}MB.`;
    return false;
  }
  return true;
}

/**
 * Validate a file for encryption requirements.
 *
 * @param {Event} event - The form submission event.
 * @param {HTMLFormElement} form - The form element being validated.
 */
function validateFile(event, form) {
  const fileInput = form.querySelector('input[type="file"]');
  if (!fileInput) return;

  const file = fileInput.files[0];
  const acceptedTypes = fileInput.accept.split(',');

  fileInput.classList.remove('is-invalid');
  const feedback = fileInput.nextElementSibling;

  if (!file) {
    setInvalid('Harap pilih file.');
    return;
  }

  if (!file.type.startsWith('image/')) {
    setInvalid('Harap unggah file gambar yang valid.');
    return;
  }

  if (!validateFileSize(fileInput)) {
    event.preventDefault();
    return;
  }

  const extension = file.name.split('.').pop().toLowerCase();
  const validExtensions = supportedFormats.map(f => f.name.toLowerCase());

  if (!validExtensions.includes(extension)) {
    setInvalid(`Format file tidak valid. Format yang didukung: ${validExtensions.join(', ')}`);
    return;
  }

  function setInvalid(message) {
    event.preventDefault();
    fileInput.classList.add('is-invalid');
    fileInput.setCustomValidity(message);
    feedback.textContent = message;
  }
}

/**
 * Copy text content from an input element to the clipboard.
 *
 * @param {string} element - The selector for the input element.
 * @param {HTMLElement} thisElement - The button element that triggered the copy action.
 */
function copyToClipboard(element, thisElement) {
  const input = $(element);
  if (!input.length) return;
  input.select();
  document.execCommand('copy');
  $(thisElement).html('<i class="fas fa-check fa-fw"></i>');
  setTimeout(() => {
    $(thisElement).html('<i class="fas fa-copy fa-fw"></i>');
  }, 1000);
}