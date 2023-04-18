
var vueClassqiue = false;
var scenarioDom;
var scenarioPersonnagesContainerHtml;
var sequencesHtml;


var sequenceToBeDeleted;

// The personnage to be deleted or edited
var selectedPersonnage;
var sequencePersonnageToBeDeleted;

function buildSequence() {

    var sequenceNumber = $('.sequence-scenario-container').length + 1;
    personnages = getPersonnagesScenario();
    personnagesOptions = "";
    personnages.forEach(personnage => {
        personnagesOptions += ' <option value="' + personnage.trim() + '">' + personnage.trim() + '</option>';
    });;

    return `
    <div class="sequence-scenario-container">
        <div>
            ${sequenceNumber}.
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">
                <div class="location" style="display: flex;">
                    <input type="radio" class="btn-check" name="location-${sequenceNumber}" id="btnradio1-${sequenceNumber}" value="EXT"
                        checked>
                    <label class="btn btn-outline-primary" for="btnradio1-${sequenceNumber}">EXT</label>
                    <span class="oblique-separator" style="margin: 0 4px;">/</span>
                    <input type="radio" class="btn-check" name="location-${sequenceNumber}" id="btnradio2-${sequenceNumber}" value="INT">
                    <label class="btn btn-outline-primary" for="btnradio2-${sequenceNumber}">INT</label>
                </div>
                <input type="text" name="lieu" class="form-control" style="margin: 0px 16px;"
                    placeholder="LIEU DE">

                <div class="time" style="display: flex;">
                    <input type="radio" class="btn-check" name="time-${sequenceNumber}" id="btnradio3-${sequenceNumber}" autocomplete="off"
                        checked value="JOUR">
                    <label class="btn btn-outline-primary" for="btnradio3-${sequenceNumber}">JOUR</label>
                    <span class="oblique-separator" style="margin: 0 4px;">/</span>
                    <input type="radio" class="btn-check" name="time-${sequenceNumber}" id="btnradio4-${sequenceNumber}" autocomplete="off"
                        value="NUIT">
                    <label class="btn btn-outline-primary" for="btnradio4-${sequenceNumber}">NUIT</label>
                </div>
                <div class="d-flex ps-5">
                    <button type="button" class="btn btn-danger delete-sequence-btn">
                        <i class="fas fa-trash-alt" style="color: white;"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="personnages-container">
            <span class="personnages-label">(NOM.S DU.ES PERSONNAGE.S)</span>

            <div class="add-existing-personnage-sequence">
                <select class="personnage-select form-control">
                    ${personnagesOptions}
                </select>
                <button type="button" class="btn btn-primary add-personnage-btn">
                    <i class="fas fa-plus-circle" style="color: white;"></i>
                </button>
            </div>

            <div class="add-new-personnage-sequence">
                <input type="text" class="form-control add-personnage-input" placeholder="Nom du personnage">
                <button type="button" class="btn btn-primary add-personnage-btn">
                    <i class="fas fa-plus-circle" style="color: white;"></i>
                </button>
            </div>

            <div class="liste-personnages">

            </div>
        </div>
        <div class="dialogues-descriptions">
            <div class="description-container">
                <textarea name="description" class="description-textarea form-control" placeholder="description" rows="2"></textarea>
            </div>
        </div>
        <button type="button" class="btn add-dialogue-scene-btn" style="background: #4a4d77;">
            Dialogue de personnage &nbsp;<i class="fas fa-plus-circle" style="color: white;"></i>
        </button>
        <button type="button" class="btn add-description-scene-btn" style="background: #d6982c;">
            Description de scène &nbsp;<i class="fas fa-plus-circle" style="color: white;"></i>
        </button>
    </div>
    `;
}

function buildScenarioPersonnageListItem(nom) {
    return `
    <div class="liste-personnage-item">
        <button type="button" class="btn btn-outline-primary">
            <span> ${nom} </span>
        </button>
    </div>
    `;
}

function buildPersonnageListItem(nom) {
    // return '<div class="liste-personnage-item"> <span>' + nom + '</span>,&nbsp;</div>';
    return `
    <div class="liste-personnage-item">
        <button type="button" class="btn btn-outline-primary">
            <span> ${nom} </span>
        </button>
    ,&nbsp;</div>
    `;
}

function buildDescription() {
    return `<div class="description-container">
    <textarea class="description-textarea form-control" placeholder="description" rows="2"></textarea>
    <button type="button" class="btn btn-danger delete-description-btn">
        <i class="fas fa-trash-alt" style="color: white;" /></i>
    </div>`;
    // return '<textarea class="description-textarea" placeholder="description" rows="2"></textarea>';
}

function getPersonnagesScenario() {
    personnages = $('#liste-personnages-scenario span')
        .filter(e => e.innerText != "")
        .map(function () {
            return $(this).text()
        }).get();

    return personnages;
}

function getPersonnagesSequence(sequenceJqueryObject) {
    personnages = sequenceJqueryObject.find('.liste-personnage-item').map(function () {
        return $(this).children('span').text()
    }).get();
    return personnages;
}

function buildPersonnagesOptionsList() {

    var personnagesOptions = "";

    personnages = getPersonnagesScenario();

    personnagesOptions = personnages.map(function (n) {
        return '<option value="' + n + '">' + n + '</option>'
    }).join("");

    return personnagesOptions;
}

function buildDialoguePersonnage() {

    const personnagesOptions = buildPersonnagesOptionsList();

    if (personnagesOptions.trim() == "") {
        alert("Commencez par entrer des personnages");
        return;
    }

    return '<div class="personnage-dialogue">' +
        '<select class="form-control personnage-select"> ' + personnagesOptions + ' </select>' +
        '<input type="text" class="form-control" style="margin: 0px 16px;" placeholder="Emotion">' +
        //delte button
        '<button type="button" class="btn btn-danger delete-dialogue-personnage-btn"> <i class="fas fa-trash-alt" style="color: white;" /></i> </button>' +
        '<textarea class="dialogue-textarea form-control" placeholder="dialogue" rows="2"></textarea>' +
        '</div>';
}

function deleteDialoguePersonnage(elt) {

    $("#delete-dialogue-confirm-modal .btn-danger").off();
    $("#delete-dialogue-confirm-modal .btn-danger").on("click", function () {
        $(elt).parent().remove();
        $("#delete-dialogue-confirm-modal").modal("hide");
    });

    $("#delete-dialogue-confirm-modal").modal("show");
}

function deleteDescription(elt) {

    $("#delete-description-confirm-modal .btn-danger").off();
    $("#delete-description-confirm-modal .btn-danger").on("click", function () {
        $(elt).parent().remove();
        $("#delete-description-confirm-modal").modal("hide");
    });

    $("#delete-description-confirm-modal").modal("show");
}

function removePersonnageListItem() {
    $('.liste-personnage-item').remove();
}

function addPersonnage(elt, shouldShowWarning = true, shouldClearInput = true) {

    const nom = $(elt).siblings('.add-personnage-input').val().trim().toUpperCase();

    if (nom == "") {
        alert("Veuillez entrer le nom du personnage");
        return;
    }

    if ($("#liste-personnages-scenario .liste-personnage-item span:contains('" + nom + "')")
        .filter(function () { return $(this).text().trim().toUpperCase() === nom; })
        .length
    ) {
        if (shouldShowWarning) {
            alert("Le personnage a déjà été ajouté au scenario");
        }
        return;
    }

    // Update list personnages displayed
    $("#liste-personnages-scenario").append(buildScenarioPersonnageListItem(nom));

    // Update list personnages select
    $(".personnage-select").each(function (index) {
        $(this).append($('<option>', { value: nom, text: nom }));
    })

    if (shouldClearInput)
        $(elt).siblings('.add-personnage-input').val("");
}

function addPersonnageToScenarioAndSequence(elt) {
    // Add personnage to scenario
    addPersonnage(elt, false, false);
    // Add personnage to sequence
    addPersonnageSequence(elt, true);
    // Clear input
    $(elt).siblings('.add-personnage-input').val("");
}

/**
 *
 * @param {*} elt : le bouton sur lequel l'utilisateur a cliqué
 * @param {*} shouldShowWarning : Booléen déterminant si le message d'erreur doit être affiché
 * @returns void
 * Cette fonction est utilisée pour ajouter un personnage à une séquence
 */
function addPersonnageSequence(elt, shouldShowWarning = true) {

    var nom = "";

    // Le personnage est ajouté depuis le champ de texte
    if($(elt).siblings('.add-personnage-input').length > 0){
        nom = $(elt).siblings('.add-personnage-input').val().trim().toUpperCase();
    }
    // Le personnage est ajouté depuis la liste déroulante
    else{
        nom = $(elt).siblings('.personnage-select').find(":selected").val().trim().toUpperCase();
    }

    if (nom == "") {
        alert("Veuillez entrer le nom du personnage");
        return;
    }

    if ($(elt).closest(".personnages-container").find(".liste-personnage-item span:contains('" + nom + "')")
        .filter(function () { return $(this).text().trim().toUpperCase() === nom; })
        .length
    ) {
        if (shouldShowWarning) {
            alert("Le personnage a déjà été ajouté à la séquence");
        }
        return;
    }

    // Update list personnages displayed
    $(elt).closest(".personnages-container").find(".liste-personnages").append(buildScenarioPersonnageListItem(nom));

}

// Change the name of the personnage
function editPersonnage() {

    const newNom = $("#newNomInput").val().trim().toUpperCase();

    if (newNom == "") {
        alert("Veuillez entrer le nom du personnage");
        return false;
    }

    // Edit the name of the personnage in the list
    $('.liste-personnage-item span').each(function (index, element) {
        if ($(this).text().trim().toUpperCase() == selectedPersonnage.toUpperCase()) {
            $(this).text(newNom);
        }
    })

    // Edit the name of the personnage in the select
    $('.personnage-select option[value="' + selectedPersonnage + '"]').attr("value", newNom).text(newNom);
    // $('.personnage-select option[value="' + selectedPersonnage + '"]').val(newNom);

}

// Delete the personnage from the scenario
function deletePersonnage() {

    // Delete dialogues of the personnage
    $('.personnage-dialogue option[value="' + selectedPersonnage + '"]:selected').parent().parent().remove();


    // Delete the personnage from the list
    $('.liste-personnage-item span').each(function (index, element) {
        if ($(element).text().trim().toUpperCase() == selectedPersonnage) {
            $(this).parent().parent().remove();
        }
    })

    // Delete the personnage from the selects
    $('.personnage-select option[value="' + selectedPersonnage + '"]').remove();

}

// Delete the personnage from the sequence
function deletePersonnageSequence() {

    personnage = $(sequencePersonnageToBeDeleted).find("span").text().trim();

    // Delete dialogues of the personnage
    $(sequencePersonnageToBeDeleted).closest(".sequence-scenario-container").find('.personnage-dialogue option[value="' + personnage + '"]:selected').parent().parent().remove();

    // Delete the personnage from the list of personnages of the sequence
    $(sequencePersonnageToBeDeleted).parent().remove()

    // Delete the personnage from the selects of the sequence
    $(sequencePersonnageToBeDeleted).closest(".sequence-scenario-container").find('.personnage-select option[value="' + personnage + '"]').remove();

}

function getSequenceDialoguesDescriptions(sequenceJqueryObject) {

    var results = [];

    sequenceJqueryObject.children(".dialogues-descriptions").children().each(function (index, element) {
        //console.log($(element));
        if ($(element).hasClass("description-container")) {
            results.push({
                type: "description",
                value: {
                    description: $(this).find('.description-textarea').first().val()
                }
            });
        }
        else if ($(element).hasClass("personnage-dialogue")) {
            results.push({
                type: "dialogue",
                value: {
                    personnage: $(this).children("select").children("option:checked").val(),
                    emotion: $(this).children('input').val(),
                    dialogue: $(this).children('textarea').val()
                }
            });
        }
    })

    return results;
}

function getSequencePersonnages(sequenceJqueryObject) {

    var results = [];

    sequenceJqueryObject.find(".liste-personnage-item span").each(function (index, element) {
        results.push($(element).html().trim());
    })

    sequenceJqueryObject.find(".personnage-select option:selected span").each(function (index, element) {
        results.push($(element).html().trim());
    })

    return results;

}

function switchToVueClassique() {

    if (vueClassqiue) {
        vueClassqiue = false;
        $("#scenario-container").removeClass("scenario-vue-classique");
        $("#sequences-vue-classique").html("");
        return;
    }

    vueClassqiue = true;


    // $("#scenario-personnages-container-vue-classique").html( $("#scenario-personnages-container").html() );
    sequencesHtml = $("#sequences").html();
    sequencesHtml = sequencesHtml.replaceAll('id="', 'id="seqVueC');
    sequencesHtml = sequencesHtml.replaceAll('for="', 'for="seqVueC');
    sequencesHtml = sequencesHtml.replaceAll('name="', 'name="seqVueC');

    $("#sequences-vue-classique").html(sequencesHtml);

    $("#sequences").find("input").each(function (idx) {
        $("#sequences-vue-classique").find("input").eq(idx).val($(this).val());
    });

    $("#sequences").find("textarea").each(function (idx) {
        $("#sequences-vue-classique").find("textarea").eq(idx).val($(this).val());
    });

    // Switch to vue classique
    $("#scenario-container").addClass("scenario-vue-classique");

    // replace the lieu input by a span
    $("#sequences-vue-classique input[name^='seqVueClieu']").each(function (index, element) {
        value = $(element).val();
        $(element).replaceWith("<span> - " + value + " - </span>");
    });

    // Replace liste personnages buttons by spans
    $("#sequences-vue-classique .personnages-container .liste-personnage-item").each(function (index, element) {
        personnage = $(element).find("span").text();
        $(element).replaceWith("<span>" + personnage + "</span>,&nbsp;");
    });

    // Replace selects of personnages by spans
    $("#sequences-vue-classique .personnage-dialogue select").each(function (index, element) {
        value = $(element).find(":selected").text();
        $(element).replaceWith("&nbsp;&nbsp;&nbsp;<span>" + value.toUpperCase() + "</span>");
    });

    // Replace input emotions by spans
    $("#sequences-vue-classique .personnage-dialogue input").each(function (index, element) {
        value = $(element).val();
        $(element).replaceWith("<span>" + value + "</span>");
    });

    // Replace textarea by divs
    $("#sequences-vue-classique .personnage-dialogue textarea, #sequences-vue-classique .description-textarea").each(function (index, element) {
        value = $(element).val();
        $(element).replaceWith("<div style='margin-bottom: 16px;'>" + value + "</div>");
    });

}

function deleteSequence() {
    var myModalEl = document.getElementById("delete-sequence-confirm-modal");
    var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
    $("#" + sequenceToBeDeleted).remove();
    modal.hide();
}

function scenario_init() {

    $(document).on('click', '.remove-personnage-btn', function () {
        $(this).parent().remove();
    });

    initListeners();

}

function initListeners() {

    // Ajouter une sequence au scenario on click
    $("#add-sequence-menu").off();
    $("#add-sequence-menu").on("click", function () {
        $("#sequences").append(buildSequence());
        setTimeout(() => {
            initListeners();
        }, 1000);
    });

    // Supprimer une sequence
    $(".delete-sequence-btn").off();
    $(".delete-sequence-btn").on("click", function () {

        if ($(".sequence-scenario-container").length < 2) {
            alert("Vous devez avoir au moins une séquence");
            return;
        }

        var myModalEl = document.getElementById("delete-sequence-confirm-modal");
        var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
        modal.show();

        sequenceToBeDeleted = $(this).closest(".sequence-scenario-container").attr('id');

    });


    $(".add-personnage-btn").off();

    // Ajouter personnage au scenario
    $("#scenario-personnages-container .add-personnage-btn").on("click", function () {
        addPersonnage(this);
        setTimeout(() => {
            initListeners();
        }, 1000);
    });

    // Ajouter personnage existant à une sequence on click
    $(".add-existing-personnage-sequence .add-personnage-btn").on("click", function () {
        addPersonnageSequence(this);
        setTimeout(() => {
            initListeners();
        }, 1000);
    });

    // Ajouter nouveau personnage à une sequence on click
    $(".add-new-personnage-sequence .add-personnage-btn").on("click", function () {
        addPersonnageToScenarioAndSequence(this);
        setTimeout(() => {
            initListeners();
        }, 1000);
    });

    // On click on a scenario personnage button, open modal and select the personnage
    $("#scenario-personnages-container .liste-personnage-item button").off();
    $("#scenario-personnages-container .liste-personnage-item button").on("click", function () {
        selectedPersonnage = $(this).find("span").text().trim();
        $(".nom_personnage").text(selectedPersonnage);
        setTimeout(() => {
            $("#edit-personnage-modal").modal("show");
        }, 100);
    });

    // On click on a sequence personnage button, open modal and select the personnage
    $("#sequences .liste-personnage-item button").off();
    $("#sequences .liste-personnage-item button").on("click", function () {
        sequencePersonnageToBeDeleted = this;
        $("#personnage-delete").text($(this).find("span").text().trim());
        setTimeout(() => {
            $("#delete-personnage-confirm-modal").modal("show");
        }, 100);
    });

    // Ajouter une description à une sequence on click
    $(".add-description-scene-btn").off();
    $(".add-description-scene-btn").on("click", function () {
        $(this).siblings('.dialogues-descriptions').append(buildDescription());
        setTimeout(() => {
            initListeners();
        }, 1000);
    });

    // Add dialogue personnage on click
    $(".add-dialogue-scene-btn").off();
    $(".add-dialogue-scene-btn").on("click", function () {
        $(this).siblings('.dialogues-descriptions').append(buildDialoguePersonnage());
        setTimeout(() => {
            initListeners();
        }, 1000);
    });

    // Delete dialogue personnage on click
    $(".delete-dialogue-personnage-btn").off();
    $(".delete-dialogue-personnage-btn").on("click", function () {
        deleteDialoguePersonnage(this);
    });

    // Delete description on click
    $(".delete-description-btn").off();
    $(".delete-description-btn").on("click", function () {
        deleteDescription(this);
    });

}

function scenarioValidate() {

    sequences = new Array();

    personnages = getPersonnagesScenario();

    $('.sequence-scenario-container').each(function (index, element) {

        sequence = {
            location: $(element).find('input[name^="location"]:checked').val(),
            time: $(element).find('input[name^="time"]:checked').val(),
            lieu: $(element).find('input[name^="lieu"]').val(),
            dialogues_descriptions: new Array(),
            personnages: new Array()
        };

        sequence.dialogues_descriptions = getSequenceDialoguesDescriptions($(element));
        sequence.personnages = getSequencePersonnages($(element));

        sequences.push(sequence);
    });


    data = {
        personnages,
        sequences
    };

    $("#action-form input[name='scenario']").val(JSON.stringify(data));
    $("#action-form").submit();

}

function scenarioSave() {
    scenarioValidate();
}