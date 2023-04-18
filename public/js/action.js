// Used to init popovers
function initPopovers() {
    // Enable popover
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            container: 'body',
            html: true,
        })
    });
}

var leaveLink = "";
// Use to know if we should warn the user to save his job before leaving
var mustWarnUserToSave = false;

function init() {

    // Initialiser les popovers, Aide et "popovers de Mise en page de ton scenario"
    initPopovers();

    // Check if scenario init is defined as a function, call it if it is
    if (typeof scenario_init === 'function'){
        scenario_init();
    }

    $("#validateIcon").on("click", function () {
        if (typeof isScenario !== 'undefined') {
            scenarioValidate();
        } else {
            $("#validateModal").modal("show");
        }
    });

    $("#saveIcon").on("click", function () {
        if (typeof isScenario !== 'undefined') {
            scenarioSave();
        } else
            $("#saveModal").modal("show");
    });

    $("#validate-button").on("click", function () {
        $("#action-form").submit();
    });

    $("#saveModal-button").on("click", function () {
        // Set the redirect url to the current relative url
        $("#action-form input[name='redirect_url']").val(window.location.pathname + window.location.search);
        $("#action-form").submit();
    });

    $("#scenario-vue-classique-btn").on("click", function () {
        switchToVueClassique();
    })

    // Quand un utilisateur clique sur un menu de la barre de gauche
    // Lui demander de sauver avant de passer
    $(".action-menu-item a").on("click", function () {

        if (!mustWarnUserToSave) {
            window.location.href = $(this).data("href");
            return;
        }

        leaveLink = $(this).data("href");
        let myModalEl = document.getElementById("leave-confirm-modal");
        let modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
        modal.show();
    })

    // On changes of input content, set mustWarnUserToSave to true
    $("input,textarea").on('input',function(e){
        mustWarnUserToSave = true;
    });

}

function leavePage() {
    window.location.href = leaveLink;
    mustWarnUserToSave = false;
}

$(function () {
    init();
});
