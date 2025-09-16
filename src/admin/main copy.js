import './main.scss'
// import domtoimage from 'dom-to-image-more';

// console.log(domtoimage)

// const { select, subscribe } = wp.data;
// const store = "core/block-editor";

// // Suscripción a cambios
// const unsubscribe = subscribe(() => {

//     const blocks = select(store).getBlocks();
//     if(blocks.length) {

//       setTimeout(() => {

//         const el = document.querySelector('.wp-block-cover');

//         console.log(el)
//         domtoimage
//         .toPng(el)
//         .then(function (dataUrl) {

//           var img = new Image();
//           img.src = dataUrl;
//           document.body.appendChild(img);
//         })
//         .catch(function (error) {
//             console.error('oops, something went wrong!', error);
//         });

//       }, 0);

//       unsubscribe()
//     }

// });