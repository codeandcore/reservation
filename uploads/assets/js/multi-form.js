/**Customozed for both Report and add restorant */
(function ( $ ) {
  $.fn.multiStepForm = function(args) {
      if(args === null || typeof args !== 'object' || $.isArray(args))
        throw  " : Called with Invalid argument";
      var form = this;
      var tabs = form.find('.restro_info_row');
      var steps = form.find('.stepItem');
      steps.each(function(i, e){
        $(e).on('click', function(ev){
        });
      });
      form.navigateTo = function (i) {/*index*/
        /*Mark the active section with the class 'active'*/
        tabs.removeClass('active').eq(i).addClass('active');
        // Show only the navigation buttons that make sense for the active section:
        form.find('#prevBtn, .prevBtn').toggle(i > 0);
        atTheEnd = i >= tabs.length - 1;
        form.find('#nextBtn,.nextBtn').toggle(!atTheEnd);
        // console.log('atTheEnd='+atTheEnd);
        form.find('.submit').toggle(atTheEnd);
        fixStepIndicator(curIndex());
        return form;
      }
      function curIndex() {
        /*Return the active index by looking at which section has the class 'active'*/

        if($("#step_report_form").length != 0) {
          //it exist
          if(tabs.index(tabs.filter('.active'))!=0){
            jQuery(".start-report-btn").hide();
            //jQuery(".nextBtn").show();
          }else if(tabs.index(tabs.filter('.active'))==0){
            jQuery(".nextBtn").hide();
            jQuery(".start-report-btn").show();
  
            
          }
        }


        return tabs.index(tabs.filter('.active'));
      }
      function fixStepIndicator(n) {
        steps.each(function(i, e){
          i == n ? $(e).addClass('active').prevAll().addClass('active completed') : $(e).removeClass('active completed');
        });
      }
      /*#prevBtn, .prevBtn button is easy, just go back */
      form.find('#prevBtn, .prevBtn').click(function() {
        form.navigateTo(curIndex() - 1);
      });

      /* Next button goes forward iff active block validates */
      form.find('#nextBtn,.nextBtn').click(function() {
        if('validations' in args && typeof args.validations === 'object' && !$.isArray(args.validations)){
          if(!('noValidate' in args) || (typeof args.noValidate === 'boolean' && !args.noValidate)){
            //console.log(args,'--Form fields');
            form.validate(args.validations);
            if(form.valid() == true){
              if($("#step_report_form").length != 0){
                if(myVal()==true){
                  form.navigateTo(curIndex() + 1);
                  return true;
                }
              }else{
                form.navigateTo(curIndex() + 1);
                return true;
              }

              // form.navigateTo(curIndex() + 1);
              // return true;

            }
            if($("#step_report_form").length != 0){
              Swal.fire('Please select atleast one value for each field', '', 'info');
            }
            return false;
          }
        }
        form.navigateTo(curIndex() + 1);
      });
      form.find('.submit').on('click', function(e){
        if(typeof args.beforeSubmit !== 'undefined' && typeof args.beforeSubmit !== 'function')
          args.beforeSubmit(form, this);
        /*check if args.submit is set false if not then form.submit is not gonna run, if not set then will run by default*/        
        if(typeof args.submit === 'undefined' || (typeof args.submit === 'boolean' && args.submit)){
          if($("#step_report_form").length != 0){
            if(myVal()==true){
              form.submit();
            }else{
              Swal.fire('Please select atleast one value for each field', '', 'info');
            }
          }else{
            form.submit();
          }

          // form.submit();
        }
        return form;
      });
      /*By default navigate to the tab 0, if it is being set using defaultStep property*/
      typeof args.defaultStep === 'number' ? form.navigateTo(args.defaultStep) : null;

      form.noValidate = function() {
      }

      /**Cutom form validation */
      // form.validate = function(validations) {
      function myVal(validations) {
        if(curIndex()==1){
          // Custom validation logic for dates checkboxes
          var select_daysCheckboxes = form.find('input[type="checkbox"][name^="select_days"]');
          var sel_attend_typeCheckboxes = form.find('input[type="checkbox"][name^="sel_attend_type"]');
          var sel_statusCheckboxes = form.find('input[type="checkbox"][name^="booking_status"]');
          var sel_property_typeCheckboxes = form.find('input[type="checkbox"][name^="sel_property_type"]');
          var select_daysGroupIsValid = false;
          var sel_attend_typeGroupIsValid = false;
          var sel_statusGroupIsValid = false;
          var sel_property_typeGroupIsValid = false;
      
          select_daysCheckboxes.each(function() {
            if ($(this).prop('checked')) {
              select_daysGroupIsValid = true;
              //return false; // break the loop if at least one checkbox is checked
            }
          });
          sel_attend_typeCheckboxes.each(function() {
            if ($(this).prop('checked')) {
              sel_attend_typeGroupIsValid = true;
              //return false; // break the loop if at least one checkbox is checked
            }
          });
          sel_statusCheckboxes.each(function() {
            if ($(this).prop('checked')) {
              sel_statusGroupIsValid = true;
              //return false; // break the loop if at least one checkbox is checked
            }
          });
          sel_property_typeCheckboxes.each(function() {
            if ($(this).prop('checked')) {
              sel_property_typeGroupIsValid = true;
              //return false; // break the loop if at least one checkbox is checked
            }
          });

          //console.log(jQuery('.multi-step-slect-rest-names').val(),'----multiselecty-res--before--');
          if(jQuery('.multi-step-slect-rest-names').val()==null){
            $('.multi-step-slect-rest-names option').prop('selected', true);
          }
          //console.log(jQuery('.multi-step-slect-rest-names').val(),'----multiselecty-res--After--');

          // return false;
          
      
          // if (!select_daysGroupIsValid || !sel_attend_typeGroupIsValid || !sel_statusGroupIsValid || !sel_property_typeGroupIsValid || (jQuery('.multi-step-slect-rest-names').val()==null)) {
          if (!select_daysGroupIsValid || !sel_attend_typeGroupIsValid || !sel_statusGroupIsValid || !sel_property_typeGroupIsValid || (jQuery('.multi-step-slect-rest-names').val()==null)) {
            // Display an error message or perform any other action for invalid checkboxes
            //alert('Please select at least one checkbox.');
            return false;
          }
      
          
        }
        if(curIndex()==2){
          var generic_columnsCheckboxes = form.find('input[type="checkbox"][name^="generic_columns"]');
          // var generic_columnsCheckboxes = form.find('input[type="checkbox"][name^="generic_columns"]');
          var generic_columnsGroupIsValid = false;

          generic_columnsCheckboxes.each(function() {
            if ($(this).prop('checked')) {
              generic_columnsGroupIsValid = true;
              //return false; // break the loop if at least one checkbox is checked
            }
          });

          /**Check the Selected dates from step one */
          var select_daysCheckboxes = form.find('input[type="checkbox"][name^="select_days"]');
          var select_daysGroupIsValid = false;
          var numOfdatesCNT = 0; 
          var numOfdates = [];
          var dateVal = '';
          select_daysCheckboxes.each(function() {
            if ($(this).prop('checked')) {
              numOfdatesCNT = numOfdatesCNT+1;
              dateVal =$(this).val();
              numOfdates[dateVal] = false;//push in array
              
              var dateVar = form.find('input[type="checkbox"][name^="days_columns[\''+$(this).val()+'\']"]');
              /**Check checboxes of dates selected on step 1 */
              dateVar.each(function() {
                if ($(this).prop('checked')) {
                  //console.log($(this).val(),'--is date checked frrm 2');
                  select_daysGroupIsValid = true;
                  numOfdates[dateVal] = true;
                }
              });
            }
          });

          var hasFalseValue = Object.values(numOfdates).includes(false);
          if (!generic_columnsGroupIsValid || hasFalseValue) {
            // Display an error message or perform any other action for invalid checkboxes
            return false;
          }

        }
        return true; // return true if all validations pass
      };


      return form;
  };
}( jQuery ));
/**Customozed for both Report and add restorant END*/


/**Only Report generate works */
// (function ( $ ) {
//   $.fn.multiStepForm = function(args) {
//       if(args === null || typeof args !== 'object' || $.isArray(args))
//         throw  " : Called with Invalid argument";
//       var form = this;
//       var tabs = form.find('.restro_info_row');
//       var steps = form.find('.stepItem');
//       steps.each(function(i, e){
//         $(e).on('click', function(ev){
//         });
//       });
//       form.navigateTo = function (i) {/*index*/
//         /*Mark the active section with the class 'active'*/
//         tabs.removeClass('active').eq(i).addClass('active');
//         // Show only the navigation buttons that make sense for the active section:
//         form.find('#prevBtn, .prevBtn').toggle(i > 0);
//         atTheEnd = i >= tabs.length - 1;
//         form.find('#nextBtn,.nextBtn').toggle(!atTheEnd);
//         // console.log('atTheEnd='+atTheEnd);
//         form.find('.submit').toggle(atTheEnd);
//         fixStepIndicator(curIndex());
//         return form;
//       }
//       function curIndex() {
//         /*Return the active index by looking at which section has the class 'active'*/
//         if(tabs.index(tabs.filter('.active'))!=0){
//           jQuery(".start-report-btn").hide();
//           //jQuery(".nextBtn").show();
//         }else if(tabs.index(tabs.filter('.active'))==0){
//           jQuery(".nextBtn").hide();
//           jQuery(".start-report-btn").show();

          
//         }

//         return tabs.index(tabs.filter('.active'));
//       }
//       function fixStepIndicator(n) {
//         steps.each(function(i, e){
//           i == n ? $(e).addClass('active').prevAll().addClass('active completed') : $(e).removeClass('active completed');
//         });
//       }
//       /*#prevBtn, .prevBtn button is easy, just go back */
//       form.find('#prevBtn, .prevBtn').click(function() {
//         form.navigateTo(curIndex() - 1);
//       });

//       /* Next button goes forward iff active block validates */
//       form.find('#nextBtn,.nextBtn').click(function() {
//         if('validations' in args && typeof args.validations === 'object' && !$.isArray(args.validations)){
//           if(!('noValidate' in args) || (typeof args.noValidate === 'boolean' && !args.noValidate)){
//             console.log(args,'--Form fields');
//             form.validate(args.validations);
//             if(form.valid() == true){
//               if(myVal()==true){
//                 form.navigateTo(curIndex() + 1);
//                 return true;
//               }
//               // form.navigateTo(curIndex() + 1);
//               // return true;

//             }
//             Swal.fire('Please select atleast one value for each field', '', 'info');
//             return false;
//           }
//         }
//         form.navigateTo(curIndex() + 1);
//       });
//       form.find('.submit').on('click', function(e){
//         if(typeof args.beforeSubmit !== 'undefined' && typeof args.beforeSubmit !== 'function')
//           args.beforeSubmit(form, this);
//         /*check if args.submit is set false if not then form.submit is not gonna run, if not set then will run by default*/        
//         if(typeof args.submit === 'undefined' || (typeof args.submit === 'boolean' && args.submit)){
//           if(myVal()==true){
//             form.submit();
//           }else{
//             Swal.fire('Please select atleast one value for each field', '', 'info');
//           }
//           // form.submit();
//         }
//         return form;
//       });
//       /*By default navigate to the tab 0, if it is being set using defaultStep property*/
//       typeof args.defaultStep === 'number' ? form.navigateTo(args.defaultStep) : null;

//       form.noValidate = function() {
//       }

//       /**Cutom form validation */
//       // form.validate = function(validations) {
//       function myVal(validations) {
//         if(curIndex()==1){
//           // Custom validation logic for dates checkboxes
//           var select_daysCheckboxes = form.find('input[type="checkbox"][name^="select_days"]');
//           var sel_attend_typeCheckboxes = form.find('input[type="checkbox"][name^="sel_attend_type"]');
//           var sel_statusCheckboxes = form.find('input[type="checkbox"][name^="sel_status"]');
//           var sel_property_typeCheckboxes = form.find('input[type="checkbox"][name^="sel_property_type"]');
//           var select_daysGroupIsValid = false;
//           var sel_attend_typeGroupIsValid = false;
//           var sel_statusGroupIsValid = false;
//           var sel_property_typeGroupIsValid = false;
      
//           select_daysCheckboxes.each(function() {
//             if ($(this).prop('checked')) {
//               select_daysGroupIsValid = true;
//               //return false; // break the loop if at least one checkbox is checked
//             }
//           });
//           sel_attend_typeCheckboxes.each(function() {
//             if ($(this).prop('checked')) {
//               sel_attend_typeGroupIsValid = true;
//               //return false; // break the loop if at least one checkbox is checked
//             }
//           });
//           sel_statusCheckboxes.each(function() {
//             if ($(this).prop('checked')) {
//               sel_statusGroupIsValid = true;
//               //return false; // break the loop if at least one checkbox is checked
//             }
//           });
//           sel_property_typeCheckboxes.each(function() {
//             if ($(this).prop('checked')) {
//               sel_property_typeGroupIsValid = true;
//               //return false; // break the loop if at least one checkbox is checked
//             }
//           });

//           console.log(jQuery('.multi-step-slect-rest-names').val(),'----multiselecty-res--before--');
//           if(jQuery('.multi-step-slect-rest-names').val()==null){
//             $('.multi-step-slect-rest-names option').prop('selected', true);
//           }
//           console.log(jQuery('.multi-step-slect-rest-names').val(),'----multiselecty-res--After--');

//           // return false;
          
      
//           // if (!select_daysGroupIsValid || !sel_attend_typeGroupIsValid || !sel_statusGroupIsValid || !sel_property_typeGroupIsValid || (jQuery('.multi-step-slect-rest-names').val()==null)) {
//           if (!select_daysGroupIsValid || !sel_attend_typeGroupIsValid || !sel_statusGroupIsValid || !sel_property_typeGroupIsValid || (jQuery('.multi-step-slect-rest-names').val()==null)) {
//             // Display an error message or perform any other action for invalid checkboxes
//             //alert('Please select at least one checkbox.');
//             return false;
//           }
      
          
//         }
//         if(curIndex()==2){
//           var generic_columnsCheckboxes = form.find('input[type="checkbox"][name^="generic_columns"]');
//           // var generic_columnsCheckboxes = form.find('input[type="checkbox"][name^="generic_columns"]');
//           var generic_columnsGroupIsValid = false;

//           generic_columnsCheckboxes.each(function() {
//             if ($(this).prop('checked')) {
//               generic_columnsGroupIsValid = true;
//               //return false; // break the loop if at least one checkbox is checked
//             }
//           });

//           /**Check the Selected dates from step one */
//           var select_daysCheckboxes = form.find('input[type="checkbox"][name^="select_days"]');
//           var select_daysGroupIsValid = false;
//           var numOfdatesCNT = 0; 
//           var numOfdates = [];
//           var dateVal = '';
//           select_daysCheckboxes.each(function() {
//             if ($(this).prop('checked')) {
//               numOfdatesCNT = numOfdatesCNT+1;
//               dateVal =$(this).val();
//               numOfdates[dateVal] = false;//push in array
              
//               var dateVar = form.find('input[type="checkbox"][name^="days_columns[\''+$(this).val()+'\']"]');
//               /**Check checboxes of dates selected on step 1 */
//               dateVar.each(function() {
//                 if ($(this).prop('checked')) {
//                   console.log($(this).val(),'--is date checked frrm 2');
//                   select_daysGroupIsValid = true;
//                   numOfdates[dateVal] = true;
//                 }
//               });
//             }
//           });

//           var hasFalseValue = Object.values(numOfdates).includes(false);
//           if (!generic_columnsGroupIsValid || hasFalseValue) {
//             // Display an error message or perform any other action for invalid checkboxes
//             return false;
//           }

//         }
//         return true; // return true if all validations pass
//       };


//       return form;
//   };
// }( jQuery ));

/**Only Report generate works END */


/**OLD */
// (function ( $ ) {
//   $.fn.multiStepForm = function(args) {
//       if(args === null || typeof args !== 'object' || $.isArray(args))
//         throw  " : Called with Invalid argument";
//       var form = this;
//       var tabs = form.find('.restro_info_row');
//       var steps = form.find('.stepItem');
//       steps.each(function(i, e){
//         $(e).on('click', function(ev){
//         });
//       });
//       form.navigateTo = function (i) {/*index*/
//         /*Mark the active section with the class 'active'*/
//         tabs.removeClass('active').eq(i).addClass('active');
//         // Show only the navigation buttons that make sense for the active section:
//         form.find('#prevBtn').toggle(i > 0);
//         atTheEnd = i >= tabs.length - 1;
//         form.find('#nextBtn').toggle(!atTheEnd);
//         // console.log('atTheEnd='+atTheEnd);
//         form.find('.submit').toggle(atTheEnd);
//         fixStepIndicator(curIndex());
//         return form;
//       }
//       function curIndex() {
//         /*Return the active index by looking at which section has the class 'active'*/
//         return tabs.index(tabs.filter('.active'));
//       }
//       function fixStepIndicator(n) {
//         steps.each(function(i, e){
//           i == n ? $(e).addClass('active').prevAll().addClass('active completed') : $(e).removeClass('active completed');
//         });
//       }
//       /*#prevBtn button is easy, just go back */
//       form.find('#prevBtn').click(function() {
//         form.navigateTo(curIndex() - 1);
//       });

//       /* Next button goes forward iff active block validates */
//       form.find('#nextBtn').click(function() {
//         if('validations' in args && typeof args.validations === 'object' && !$.isArray(args.validations)){
//           if(!('noValidate' in args) || (typeof args.noValidate === 'boolean' && !args.noValidate)){
//             form.validate(args.validations);
//             if(form.valid() == true){
//               form.navigateTo(curIndex() + 1);
//               return true;
//             }
//             return false;
//           }
//         }
//         form.navigateTo(curIndex() + 1);
//       });
//       form.find('.submit').on('click', function(e){
//         if(typeof args.beforeSubmit !== 'undefined' && typeof args.beforeSubmit !== 'function')
//           args.beforeSubmit(form, this);
//         /*check if args.submit is set false if not then form.submit is not gonna run, if not set then will run by default*/        
//         if(typeof args.submit === 'undefined' || (typeof args.submit === 'boolean' && args.submit)){
//           form.submit();
//         }
//         return form;
//       });
//       /*By default navigate to the tab 0, if it is being set using defaultStep property*/
//       typeof args.defaultStep === 'number' ? form.navigateTo(args.defaultStep) : null;

//       form.noValidate = function() {
        
//       }
//       return form;
//   };
// }( jQuery ));
/**OLD END*/



/***New functionality */
jQuery('.trip-date-filter-item').change(function(){
  if($(this).is(':checked')){
    jQuery('.parent-day-fields-'+$(this).data('date')).toggle();
  }else{
    jQuery('.parent-day-fields-'+$(this).data('date')+' input[type="checkbox"]').prop('checked', false);
    jQuery('.parent-day-fields-'+$(this).data('date')).toggle();
  }
});

jQuery('.mu-step-label').click(function(){
  jQuery(this).parents('.form-group').find('input[type="checkbox"]').prop('checked', true);
});