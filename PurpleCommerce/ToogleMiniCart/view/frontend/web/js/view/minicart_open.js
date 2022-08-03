define(["jquery/ui","jquery"], function(Component, $){
    return function(config, element){
        console.log("this loaded");
        var minicart = $(element);
        minicart.on('contentLoading', function () {
            minicart.on('contentUpdated', function () {
                minicart.find('[data-role="dropdownDialog"]').dropdownDialog("open");
                setTimeout(function() {
                    $('[data-block="minicart"]').find('[data-role="dropdownDialog"]').dropdownDialog("close");
                }, 5000);
            });
        });
    }
});