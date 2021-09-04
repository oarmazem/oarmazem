
/*----------------------------------------------------------------------------

-----------------------------------------------------------------------------*/
const newlineSubstitute = '-j4jro@=';

const style = '<style> body {font-size: 20px; font-family: robot; padding: 8px;} </style> \n ';

function showHtmlSample(id) {

  code = document.getElementById(id);

  iframe = document.getElementById(id + '-html-sample'); 
 
  innerText = code.innerText;

  iframe.contentDocument.open(); iframe.contentDocument.close();
  
  iframe.contentDocument.write(style + innerText);    

  code.innerText = replaceAll('\n', newlineSubstitute, innerText);

  hljs.highlightAll();

  code.innerHTML = replaceAll(newlineSubstitute, '\n', code.innerHTML);
  
}//showHtmlSample()

/*----------------------------------------------------------------------------

-----------------------------------------------------------------------------*/
function replaceAll(oldOne, newOne, text) {

  do {

    copy = text;
    text = text.replace(oldOne, newOne);

  } while (copy != text);

  return text;
}//replaceAll()  

/*----------------------------------------------------------------------------

-----------------------------------------------------------------------------*/
function configureDocument(last, next) {

  
  headContent = document.getElementsByTagName('head')[0].innerHTML;

  document.getElementsByTagName('head')[0].innerHTML = headContent + 
  '<link rel="stylesheet" href="css/frames.css"/>' +
  '<meta charset="UTF-8">' +
  '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>'; 

  bodyContent = document.getElementsByTagName('body')[0].innerHTML;

  document.getElementsByTagName('body')[0].innerHTML = bodyContent + 
  '<footer>' +
  '<nav>' + 
  '<hr>' +
  '<a href="' + last + '" target="frame" class="nav-button nav-button-prev">Anterior</a>' +
  '<a href="' + next + '" target="frame" class="nav-button nav-button-next">Próxima</a>' +
  '</nav>' +
  '</footer>';

  buttonTags = document.getElementsByClassName("update-sample");

  for (index = 0; index < buttonTags.length; index++) {
    buttonTags[index].innerText = '\u261D Edite e experimente! \u00A0';
  }//for

  codeTags = document.getElementsByClassName('editable');

  for (index = 0; index < codeTags.length; index++) {
    codeTags[index].setAttribute('contenteditable', 'true');
    id = codeTags[index].getAttribute('id');
    showHtmlSample(id);
  }//for

}//configureDocument()