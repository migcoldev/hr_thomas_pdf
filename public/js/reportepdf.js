const checkAuth = () => {
    return new Promise((resolve, reject) => {
      setText('Checking Auth...')
      setTimeout(() => {
        resolve(true)
      }, 2000)
    })
  }

  const fetchUser = () => {
    return new Promise((resolve, reject) => {
      setText('Fetching User...')
      setTimeout(() => {
        resolve({ name: "Max" });
      }, 2000)
    })
  }
  async function pruebaAsync() {
    return "Hello";
  } 
  
 /* const newPDF = (pdf) => {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        //pdf.internal.scaleFactor = 30;
        var div_anterior = 0;
        var slides = document.getElementsByClassName("pdf-page");
        for (var i = 0; i < slides.length; i++) {
          const resAddPage = await newPage(pdf)
          div_anterior = pdfHeight;
        }

        setTimeout(function(){ 
            //pdf.save('reporte_candidato.pdf'); 
            var blob = pdf.output('blob');
            console.log(blob);
            var formData = new FormData();
            formData.append('pdf', blob);
            formData.append('name', '{{ $name }}');
            formData.append('csrf_token', '{{ csrf_token() }}');
            let fetchRes = fetch('<?php echo route('pdf.uploadblob'); ?>?name={{$name}}', {
                method: "POST", 
                body: formData 
            });
            fetchRes.then(res => 
                    res.json()).then(d => { 
                        //window.location.href = '<?php echo route("pdf.index", [ 'message' => 'archivo_importado']); ?>';
                    }) 
          //window.close();
        }, 4250);
          resolve(true)
      }, 200)
    })
  }

  const newPage = (pdf) => {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        html2canvas(document.querySelector("#"+slides[i].id), {
            scale:4,
            dpi: 300,
          }).then(canvas => {
          var img = canvas.toDataURL("image/jpeg");
          const imgProps= pdf.getImageProperties(img);
          var pdfWidth = pdf.internal.pageSize.getWidth();
          var pdfHeight = pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
          pdf.addImage(img, 'JPEG', 0, div_anterior, pdfWidth, pdfHeight);
          pdf.addPage('A4', 'portrait');
          console.log("NEW PAGE");
          resolve(true)
      });
      }, 200)
    })
  }*/