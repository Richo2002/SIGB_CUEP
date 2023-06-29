const ImageInput = document.getElementById('ImageInput');
const ImagePreview = document.getElementById('ImagePreview');

ImageInput.addEventListener('change', function(event) {
  const file = event.target.files[0];

  if (file) {
        const imageURL = URL.createObjectURL(file);
        ImagePreview.src = imageURL;
   }

   // else {
//     ImagePreview.src = '/img/dafault_photo.png';
//   }
});
