　var editor;           
  KindEditor.ready(function(K) {
    editor = K.create('#content', {           
      allowFileManager : true,   
      resizeType : 1,                                          
      uploadJson : '/index.php/sysadmin/ajax/uploadfile',
      fileManagerJson : '/index.php/sysadmin/ajax/filemanagerjson',     
      filterMode:false, 
    });  
  });