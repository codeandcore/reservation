$(document).ready(function () {
  $("[data-popup]").on("click", function () {
    $("[data-id]").removeClass("show-modal");
    $("[data-id=" + $(this).attr("data-popup") + "]").addClass("show-modal");
  });
  $(".close_btn,.popup .popup_overlay").on("click", function () {
    $(".popup").removeClass("show-modal");
  });


  // Data Table
  var datatable = $("#total_reservation").DataTable({
    language: {
        sLengthMenu: "Show Entries: _MENU_",
        searchPlaceholder: "Please search here..."
    },
      dom: '<"#top_filter"lf>rt<"#bottom_page"ip><"clear">',
        // scrollY: '54vh',
        // scrollX: true,
        // scroller: true
  });    

    
  



    $("#recent_booking").DataTable({
      "bInfo" : false,
      "bPaginate": false,
      "searching": false
    });

    $(document).on('keyup', '.search_input', function() {
        var value = $(this).val();
        console.log(value);
        datatable.search(value).draw();
    });

    $(document).on('click','.drop_dots',function(e){
       $(this).next('.action_drop').toggleClass('active');
       e.stopPropagation()
    });


    $(document).on("click", function(e) {
      if ($(e.target).is(".action_drop") === false) {
        $(".action_drop").removeClass("active");
      }
    });


    // multiple from vaidation with step start

    $(document).on('change','.radio-group input.radio',function() {      
        $('.radio-group label').removeClass('label-selected radio-error');
        $(this).parents('label').addClass('label-selected');
        if($(this).val() == 'yes')
        {
          $('.amount_field').show();
        }else{
          $('.amount_field').hide();
        }
    });

    $.validator.addMethod('amount_validate', function(value, element, param) {
        if($('.add_restro form input:checked').val() == 'yes'){          
            if($('.amount_field').val().length)
            {
              return true;
            }else{
              return false;      
            }
        }else{
            console.log('true')  
            return true;  
        }        
    });
    

    var val	=	{
      // Specify validation rules
      rules: {
        restaurants_name: {
          required: true,
        },
        website_link: {
          required: true,
          url: true
        },
        restaurants_code: {
          required: true,
        },
        location_link: {
          required: true,
          url: true
        },
        contact_number: {
          required: true,
          minlength:10,
          maxlength:10,
          digits:true
        },
        email: {
          required: true,
          email: true
        },
        description: {
          required: true
        },
        address: {
          required: true
        },
        deposit: {
          required: true
        },
        amount: {
          amount_validate: true
        },
        time_select: {
          required: function(){
            if($('#time_select').val() == '--:-- --'){
              console.log($('#time_select').val())
                return false;                      
            }else{
              console.log($('#time_select').val())
                return true;  
            }     
          }
        },
        date_select: {
          required: true
        },
        table_size: {
          required: true
        },
        capacity: {
          required: true
        },
      },
      // Specify validation error messages
      messages: {
        // fname: "First name is required",
        // email: {
        //   required: 	"Email is required",
        //   email: 		"Please enter a valid e-mail",
        // },
        // phone:{
        //   required: 	"Phone number is requied",
        //   minlength: 	"Please enter 10 digit mobile number",
        //   maxlength: 	"Please enter 10 digit mobile number",
        //   digits: 	"Only numbers are allowed in this field"
        // },
        // date:{
        //   required: 	"Date is required",
        //   minlength: 	"Date should be a 2 digit number, e.i., 01 or 20",
        //   maxlength: 	"Date should be a 2 digit number, e.i., 01 or 20",
        //   digits: 	"Date should be a number"
        // },
        // month:{
        //   required: 	"Month is required",
        //   minlength: 	"Month should be a 2 digit number, e.i., 01 or 12",
        //   maxlength: 	"Month should be a 2 digit number, e.i., 01 or 12",
        //   digits: 	"Only numbers are allowed in this field"
        // },
        // year:{
        //   required: 	"Year is required",
        //   minlength: 	"Year should be a 4 digit number, e.i., 2018 or 1990",
        //   maxlength: 	"Year should be a 4 digit number, e.i., 2018 or 1990",
        //   digits: 	"Only numbers are allowed in this field"
        // },
        // username:{
        //   required: 	"Username is required",
        //   minlength: 	"Username should be minimum 4 characters",
        //   maxlength: 	"Username should be maximum 16 characters",
        // },
        // password:{
        //   required: 	"Password is required",
        //   minlength: 	"Password should be minimum 8 characters",
        //   maxlength: 	"Password should be maximum 16 characters",
        // }
      },
      errorPlacement: function(error, element) {
        if (element.hasClass('radio')) {
            $('.deposit_radio_wrap label').addClass('radio-error');
        }
        else {
            $('.deposit_radio_wrap label').removeClass('radio-error');
             return true;
        }
     }
  }
  $("#myForm").multiStepForm({
    // defaultStep:0,
    beforeSubmit : function(form, submit){
      console.log("called before submiting the form");
      console.log(form);
      console.log(submit);
    },
    validations:val,
  }).navigateTo(0);
  // multiple from vaidation with step end
  


  // Images upload Function inti
  ImgUpload();

});


// file upload js start
document.addEventListener("DOMContentLoaded", init, false);
var AttachmentArray = [];
var arrCounter = 0;
var filesCounterAlertStatus = false;

var files_in = $(".files_in");
var Filelist = $(".files_in").parents('.form-group').find('.Filelist');
console.log(files_in);
console.log(Filelist);

//un ordered list to keep attachments thumbnails
var ul = document.createElement("ul");
ul.className = "thumb-Images";
ul.id = "imgList";

//add javascript handlers for the file upload event
function init() {
  document
    .querySelector("#files")
    .addEventListener("change", handleFileSelect, false);
}

//the handler for file upload event
function handleFileSelect(e) {
  //to make sure the user select file/files
  if (!e.target.files) return;
  //To obtaine a File reference
  var files = e.target.files;
  // Loop through the FileList and then to render image files as thumbnails.
  for (var i = 0, f; (f = files[i]); i++) {
    //instantiate a FileReader object to read its contents into memory
    var fileReader = new FileReader();
    // Closure to capture the file information and apply validation.
    fileReader.onload = (function(readerEvt) {
      return function(e) {
        //Apply the validation rules for attachments upload
        ApplyFileValidationRules(readerEvt);
        //Render attachments thumbnails.
        RenderThumbnail(e, readerEvt);
        //Fill the array of attachment
        FillAttachmentArray(e, readerEvt);
      };
    })(f);
    // Read in the image file as a data URL.
    // readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
    // More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
    fileReader.readAsDataURL(f);
  }
  document
    .getElementById("files")
    .addEventListener("change", handleFileSelect, false);
}

//To remove attachment once user click on x button
jQuery(function($) {
  $("div").on("click", ".img-wrap .close", function() {
    var id = $(this)
      .closest(".img-wrap")
      .find("img")
      .data("id");

    //to remove the deleted item from array
    var elementPos = AttachmentArray.map(function(x) {
      return x.FileName;
    }).indexOf(id);
    if (elementPos !== -1) {
      AttachmentArray.splice(elementPos, 1);
    }

    //to remove image tag
    $(this).parent() .find("img") .not() .remove();

    //to remove div tag that contain the image
    $(this)
      .parent()
      .find("div")
      .not()
      .remove();

    //to remove div tag that contain caption name
    $(this)
      .parent()
      .parent()
      .find("div")
      .not()
      .remove();

    //to remove li tag
    var lis = document.querySelectorAll("#imgList li");
    for (var i = 0; (li = lis[i]); i++) {
      if (li.innerHTML == "") {
        li.parentNode.removeChild(li);
      }
    }
  });
});

//Apply the validation rules for attachments upload
function ApplyFileValidationRules(readerEvt) {
  //To check file type according to upload conditions
  if (CheckFileType(readerEvt.type) == false) {
    alert(
      "The file (" +
        readerEvt.name +
        ") does not match the upload conditions, You can only upload jpg/png/gif files"
    );
    e.preventDefault();
    return;
  }

  //To check file Size according to upload conditions
  if (CheckFileSize(readerEvt.size) == false) {
    alert(
      "The file (" +
        readerEvt.name +
        ") does not match the upload conditions, The maximum file size for uploads should not exceed 300 KB"
    );
    e.preventDefault();
    return;
  }

  //To check files count according to upload conditions
  if (CheckFilesCount(AttachmentArray) == false) {
    if (!filesCounterAlertStatus) {
      filesCounterAlertStatus = true;
      alert(
        "You have added more than 10 files. According to upload conditions you can upload 10 files maximum"
      );
    }
    e.preventDefault();
    return;
  }
}

//To check file type according to upload conditions
function CheckFileType(fileType) {
  if (fileType == "image/jpeg") {
    return true;
  } else if (fileType == "image/png") {
    return true;
  } else if (fileType == "image/gif") {
    return true;
  } else {
    return false;
  }
  return true;
}

//To check file Size according to upload conditions
function CheckFileSize(fileSize) {
  if (fileSize < 3000000) {
    return true;
  } else {
    return false;
  }
  return true;
}

//To check files count according to upload conditions
function CheckFilesCount(AttachmentArray) {
  //Since AttachmentArray.length return the next available index in the array,
  //I have used the loop to get the real length
  var len = 0;
  for (var i = 0; i < AttachmentArray.length; i++) {
    if (AttachmentArray[i] !== undefined) {
      len++;
    }
  }
  //To check the length does not exceed 10 files maximum
  if (len > 9) {
    return false;
  } else {
    return true;
  }
}

//Render attachments thumbnails.
function RenderThumbnail(e, readerEvt) {
  var li = document.createElement("li");
  ul.appendChild(li);
  li.innerHTML = [
    '<div class="img-wrap"> <span class="close"><svg id="close_files" xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22"> <g id="Component_67_1" data-name="Component 67 – 1"> <ellipse id="Ellipse_18" data-name="Ellipse 18" cx="11.5" cy="11" rx="11.5" ry="11" fill="#00434e"/> </g> <path id="_211651_close_round_icon" data-name="211651_close_round_icon" d="M71.579,70.537,68.9,67.861l2.676-2.676a.737.737,0,1,0-1.043-1.043l-2.676,2.676-2.676-2.676a.737.737,0,0,0-1.043,1.043l2.676,2.676-2.676,2.676a.737.737,0,0,0,1.043,1.043L67.861,68.9l2.676,2.676a.737.737,0,1,0,1.043-1.043Z" transform="translate(-56.859 -56.997)" fill="#fff"/> </svg></span>' +
      '<img class="thumb" src="',
    e.target.result,
    '" title="',
    escape(readerEvt.name),
    '" data-id="',
    readerEvt.name,
    '"/>' + "</div>"
  ].join("");

  var div = document.createElement("div");
  div.className = "FileNameCaptionStyle";
  li.appendChild(div);
  div.innerHTML = [readerEvt.name].join("");
  document.getElementById("Filelist").insertBefore(ul, null);
}

//Fill the array of attachment
function FillAttachmentArray(e, readerEvt) {
  AttachmentArray[arrCounter] = {
    AttachmentType: 1,
    ObjectType: 1,
    FileName: readerEvt.name,
    FileDescription: "Attachment",
    NoteText: "",
    MimeType: readerEvt.type,
    Content: e.target.result.split("base64,")[1],
    FileSizeInBytes: readerEvt.size
  };
  arrCounter = arrCounter + 1;
}
// file upload js end
 
// Images upload Function
function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.file_upload').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
              iterator++;
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
  });
}
