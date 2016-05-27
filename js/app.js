// jquery document ready function
$(function(){

    // Auto close alert flash
    $(".alert-success").fadeTo(5000, 500).slideUp(500, function() {
        $(this).alert('close');
    });

    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

    displayTotal();

    function displayTotal() {
      var total = 0;

      var delai_charge = $("#delai_charge").val();
      if (isNumeric(delai_charge)) {
        total += parseFloat(delai_charge);
      }

      var delai_oeuvre = $("#delai_oeuvre").val();
      if (isNumeric(delai_oeuvre)) {
        total += parseFloat(delai_oeuvre);
      }

      var delai_tiers = $("#delai_tiers").val();
      if (isNumeric(delai_tiers)) {
        total += parseFloat(delai_tiers);
      }

      var marge_securite = $("#marge_securite").val();
      if (isNumeric(marge_securite)) {
        total += parseFloat(marge_securite);
      }

      $("#delai_realisation").val(total);
    }

    $('#delai_charge').on('input',function(e) {
        displayTotal();
    });
    $('#delai_oeuvre').on('input',function(e) {
        displayTotal();
    });
    $('#delai_tiers').on('input',function(e) {
        displayTotal();
    });
    $('#marge_securite').on('input',function(e) {
        displayTotal();
    });
});
