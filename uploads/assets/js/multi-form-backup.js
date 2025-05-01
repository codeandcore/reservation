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
        form.find('#prevBtn').toggle(i > 0);
        atTheEnd = i >= tabs.length - 1;
        form.find('#nextBtn').toggle(!atTheEnd);
        // console.log('atTheEnd='+atTheEnd);
        form.find('.submit').toggle(atTheEnd);
        fixStepIndicator(curIndex());
        return form;
      }
      function curIndex() {
        /*Return the active index by looking at which section has the class 'active'*/
        return tabs.index(tabs.filter('.active'));
      }
      function fixStepIndicator(n) {
        steps.each(function(i, e){
          i == n ? $(e).addClass('active').prevAll().addClass('active completed') : $(e).removeClass('active completed');
        });
      }
      /*#prevBtn button is easy, just go back */
      form.find('#prevBtn').click(function() {
        form.navigateTo(curIndex() - 1);
      });

      /* Next button goes forward iff active block validates */
      form.find('#nextBtn').click(function() {
        if('validations' in args && typeof args.validations === 'object' && !$.isArray(args.validations)){
          if(!('noValidate' in args) || (typeof args.noValidate === 'boolean' && !args.noValidate)){
            form.validate(args.validations);
            console.log(form.validate(args.validations));
            if(form.valid() == true){
              form.navigateTo(curIndex() + 1);
              return true;
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
          form.submit();
        }
        return form;
      });
      /*By default navigate to the tab 0, if it is being set using defaultStep property*/
      typeof args.defaultStep === 'number' ? form.navigateTo(args.defaultStep) : null;

      form.noValidate = function() {
        
      }
      return form;
  };
}( jQuery ));