$(document).ready(function () {
  $(".jur_select").select2();
  $(".dynamic_se").select2();

  // $("#party_tbody").empty();
  // $("#no_pa").show();
});
function setSession(key, value) {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $.ajax({
    type: "POST",
    url: "set_session",
    data: {
      key: key,
      value: value,
    },
    success: function (response) {
      console.log(response.message);
    },
    error: function (xhr) {
      console.error(xhr.responseText);
    },
  });
}
var loop_count = 0;
function add_serve() {
  loop_count++;
  if (loop_count > 14) {
    alert("Cannot add more then 15!");
  } else {
    $("#no_ser").hide();
    var html =
      "<tr id='serve_row_" +
      loop_count +
      "'><td><input type='text' class='form-control' name='party[]' value='' placeholder='Party To Serve'></td><td><select onChange='roleChangeUpdate(this)' class='form-control role-select' name='role[]'><option value='-'>Select...</option><option value='Association or Partnership'>Association or Partnership</option><option value='Authorized Person'>Authorized Person</option><option value='Business Organization, Form Unknown'>Business Organization, Form Unknown</option><option value='Corporation'>Corporation</option><option value='Defunct Corporation'>Defunct Corporation</option><option value='Estate'>Estate</option><option value='Fictitious'>Fictitious</option><option value='Individual'>Individual</option><option value='Joint Stock Company/Association'>Joint Stock Company/Association</option><option value='Minor'>Minor</option><option value='Occupant Prejudgment Claim'>Occupant Prejudgment Claim</option><option value='Public Entity'>Public Entity</option><option value='Sole Proprietorship'>Sole Proprietorship</option><option value='Trust'>Trust</option></select></td><td><input type='text' class='form-control' name='agent[]' placeholder='Registered Agent'></td> <td width='5%'><div class='btnsct'><a href='javascript:void(0)' class='pencl' style='background-color: red; color:white;' onclick='remove_more(" +
      loop_count +
      ")'><i class='fa fa-times' aria-hidden='true'></i></a></div></td></tr>";
    $("#serve_table").append(html);
  }
}
function remove_more(count, id = null) {
  if (id !== null) {
    $.ajax({
      type: "POST",
      url: "del_serves/" + id,
      type: "DELETE",
      success: (response) => {
        $("#serve_row_" + count).remove();

        // if (response[0]) {
        //   setSession("step3", "true");
        //   setTimeout(function () {
        //     location.reload();
        //   }, 500);
        // } else {
        //   setSession("step3", "true");
        //   toastr.success("Order Info Success");
        //   setTimeout(function () {
        //     location.reload();
        //   }, 500);
        // }
      },
    });
  } else {
    $("#serve_row_" + count).remove();
  }
}

function step1() {
  $("#step1s").addClass("active");
  $("#step2s").removeClass("active");
  $("#step1").addClass("show active");
  $("#step2").removeClass("show active");
  $("#step1").attr("aria-selected", "true");
  $("#step2").attr("aria-selected", "false");
}
function stepaddress() {
  // $("#step5s").addClass("active");
  // $("#step4s").removeClass("active");
  // $("#step5").addClass("show active");
  // $("#step4").removeClass("show active");
  // $("#step5").attr("aria-selected", "true");
  // $("#step4").attr("aria-selected", "false");

  $.ajax({
    type: "POST",
    url: "save_document_step",
    beforeSend: function () {
      $("#step-3-save-btn").prop("disabled", true);
      $("#step-3-save-btn").html(
        '<span id="spinner" class="fa fa-spinner fa-spin"></span> Wait'
      );
    },
    success: (response) => {
      window.location.reload();

      // if (response[0]) {
      //   setSession("step3", "true");
      //   setTimeout(function () {
      //     location.reload();
      //   }, 500);
      // } else {
      //   setSession("step3", "true");
      //   toastr.success("Order Info Success");
      //   setTimeout(function () {
      //     location.reload();
      //   }, 500);
      // }
    },
  });
}

function roleChangeUpdate(elm) {
  if ($(elm).val() == "Authorized Person" || $(elm).val() == "Individual") {
    $(elm).parent().next().find("input").attr("required", false);
    $(elm).parent().next().find("input").attr("placeholder", "Not Mandatory");
  } else {
    $(elm).parent().next().find("input").attr("required", true);

    var str = "Registered Agent";

    switch ($(elm).val()) {
      case "Association or Partnership":
      case "Joint Stock Company/Association":
      case "Corporation":
        str = "Registered Agent";
        break;
      case "Public Entity":
      case "Business Organization, Form Unknown":
      case "Fictitious":
      case "Sole Proprietorship":
        str = "Person Autorized";
        break;
      case "Estate":
        str = "The executor or administrator of the Estate.";
        break;
      case "Trust":
        str = "Name of trustee.";
        break;
      case "Defunct Corporation":
        str = "State Official/Person Authorized";
        break;
      case "Minor":
        str = "Parent of legal guardian.";
        break;
      default:
        break;
    }

    $(elm).parent().next().find("input").attr("placeholder", str);
  }
}

$(document).ready(function (e) {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $("#serve_form").submit(function (e) {
    e.preventDefault();
    var isValid = true;
    if ($('select[name="role[]"]').length === 0) {
      toastr.error("Please add at least one Serve Record.");
      return false;
    }
    $('select[name="role[]"]').each(function (index, element) {
      if ($(element).val() == "-") {
        toastr.error("Please select a valid role in field #" + (index + 1));
        isValid = false;
      }
    });
    if (!isValid) {
      return false;
    }
    let form = new FormData(this);
    $.ajax({
      type: "POST",
      url: "add_serve",
      data: form,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#serve").prop("disabled", true);
        $("#serve").html(
          '<span id="spinner" class="fa fa-spinner fa-spin"></span> Wait'
        );
      },
      success: (response) => {
        window.location.reload();

        // if (response[0]) {
        //   setSession("step3", "true");
        //   setTimeout(function () {
        //     location.reload();
        //   }, 500);
        // } else {
        //   setSession("step3", "true");
        //   toastr.success("Order Info Success");
        //   setTimeout(function () {
        //     location.reload();
        //   }, 500);
        // }
      },
    });
  });
});
function add_free_serve() {
  $("#add_free_serve").modal("toggle");
}

function removeAddress(elm, e) {
  e.preventDefault();

  var nextSibling = $(elm).parent().next(".address-info");

  if (nextSibling.length > 0) {
    $(elm).parent().add(nextSibling).remove();
  } else {
    $(elm).parent().remove();
  }
}

function leadClientChange(elm, e, id) {
  e.preventDefault();
  var checked = $(elm).is(":checked");

  if (checked) {
    $("#party_modal_billing_code_change").show();
    $("#p_bcode_change").prop("required", true);
  } else {
    $("#party_modal_billing_code_change").hide();
    $("#p_bcode_change").prop("required", false);
  }

  $("#party_form_id").val(id);
  $("#change_party").modal("show");
}

function addressTypeUpdate(elm) {
  if ($(elm).val() == "Residence") {
    $(elm).next().addClass("d-none");
  } else {
    $(elm).next().removeClass("d-none");
  }
}

$(document).ready(function () {
  var addressVal = 50;

  $("#change_party_form").on("submit", function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "change_party_lead",
      data: formData,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      processData: true, // Process the data
      success: function (response) {
        window.location.reload();
      },
    });
  });

  $(".add-more-address").on("click", function (e) {
    e.preventDefault();

    var id = $(this).data("id");

    $("#address_wrapper_" + id).append(`
    
      <div class="d-flex align-items-center justify-content-start">
        <select onchange="addressTypeUpdate(this)" name="business_type[${id}][]" class=" col-sm-2 form-control" id="business_type_${id}_${addressVal}">
            <option value="Residence">Residence</option>
            <option value="Business">Business</option>
        </select>
        <input type="text" name="s_add_business_name[${id}][]"
        class="form-control my-2 ml-2 col-sm-4 d-none"
        id="address_business_name_${id}_${addressVal}"
        placeholder="Business Name">

        <input type="text" name="s_add[${id}][]"
        oninput="addressVal('#address_${id}_${addressVal}')"
        class="form-control my-2 ml-2 col-sm-5"
        id="address_${id}_${addressVal}"
        placeholder="Address">
        <input type="hidden" name="state[${id}][]" id="state${id}_${addressVal}" >
        <input type="hidden" name="city[${id}][]" id="city${id}_${addressVal}" >
        <input type="hidden" name="zip[${id}][]" id="zip${id}_${addressVal}" >
        <input type="hidden" name="unit[${id}][]" id="unit${id}_${addressVal}" >
        <a href="#!" class="col-sm-1 text-right ml-auto" onclick="removeAddress(this, event)" style="color: #000"><i class="fa fa-times" aria-hidden="true"></i></a>
      </div>
    `);

    addressVal++;
  });

  $("#edit_address_form").on("submit", function (e) {
    e.preventDefault();

    var str = "";

    str += $("#addressFull").val();

    if ($("#unitSuite").val() != "") {
      $(currentElm).next().next().next().next().val($("#unitSuite").val());
      str += ", " + $("#unitSuite").val();
    }

    if ($("#cityAddress").val() != "") {
      $(currentElm).next().next().val($("#cityAddress").val());
      str += ", " + $("#cityAddress").val();
    }

    str += ", " + $("#stateAddress").val();
    $(currentElm).next().val($("#stateAddress").val());

    if ($("#zipAddress").val() != "") {
      $(currentElm).next().next().next().val($("#zipAddress").val());
      str += ", " + $("#zipAddress").val();
    }

    $(currentElm).val(str);

    if ($("#addressType").val() != "Residence") {
      $(currentElm).prev().val($("#businessName").val());
    } else {
      $(currentElm).prev().val("");
    }

    $(currentElm).prev().prev().val($("#addressType").val());

    addressTypeUpdate($(currentElm).prev().prev());

    $("#edit_address_modal").modal("hide");
    $("#edit_address_form")[0].reset();
    $("#business-name-wrapper").show();

    currentElm = "";
  });

  $("#add_free_serve").on("hidden.bs.modal", function (e) {
    elementToUpdateServe = "";
  });

  $("#edit_address_modal").on("hidden.bs.modal", function (e) {
    elementToUpdateServe = "";

    $("#edit_address_form")[0].reset();
    $("#business-name-wrapper").show();
    if (currentElm != "") {
      $(currentElm).val("");
    }
  });

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $("#add_free_serve_form").submit(function (e) {
    e.preventDefault();
    var formData = $(this).serialize(); // Serialize the form data

    $.ajax({
      type: "POST",
      url: "add_partyd",
      data: formData,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      processData: true, // Process the data
      success: function (response) {
        $("#add_free_serve_form")[0].reset();
        $("#add_free_serve").modal("toggle");
        $('#no_of_party option[value="-"]').attr("selected", "selected");
        $(".serve-party-name").append(
          "<option value=" + response.name + ">" + response.name + "</option>"
        );

        if (elementToUpdateServe !== "") {
          $(elementToUpdateServe)
            .find('option[value="new"]')
            .removeAttr("selected");

          $(elementToUpdateServe)
            .find('option[value="' + response.name + '"]')
            .attr("selected", "selected");
        }

        // $("#serve_table").empty();
        // $("#serve_table").append(
        //   '<tr><td colspan="5" class="text-center">Select again No of Serves form Dropdown.</td></tr>'
        // );
      },
    });
  });
});

function attorney() {
  $("#attorney_modal").modal("toggle");
}

$(document).ready(function (e) {
  // var sessionValue = $("#session-data").val();
  // if (sessionValue === "true") {
  //   $("#step2s").removeClass("active");
  //   $("#step3s").removeClass("active");
  //   $("#step4s").addClass("active");
  //   $("#step2").removeClass("show active");
  //   $("#step3").removeClass("show active");
  //   $("#step4").addClass("show active");
  //   $("#step2").attr("aria-selected", "false");
  //   $("#step3").attr("aria-selected", "false");
  //   $("#step4").attr("aria-selected", "true");
  // }
});

$(document).ready(function (e) {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $("#add_attorney").submit(function (e) {
    e.preventDefault();
    let form = new FormData(this);
    $.ajax({
      type: "POST",
      url: "add_attorney",
      data: form,
      contentType: false,
      processData: false,
      success: (response) => {
        if (response.status) {
          $("#attorney_modal").modal("toggle");
          $("#att_select").append(
            "<option value='" +
              response.data.name +
              "'>" +
              response.data.name +
              "</option>"
          );
          $('#att_select option[value="' + response.data.name + '"]').attr(
            "selected",
            "selected"
          );

          var attorneyInfoList = document.getElementById("attorney-info-list");
          attorneyInfoList.innerHTML = `
              <li class="listhdng">Attorney Name & Bar ID:</li>
              <li id="s_bid">${
                response.data.name + " " + response.data.b_id
              }</li>
              <li class="listhdng">Firm Name:</li>
              <li id="s_afm">${response.data.firm_name}</li>
              <li class="listhdng">Firm Address:</li>
              <li id="s_fa">${response.data.street_address}</li>
              <li class="listhdng">City, State, Zip Code:</li>
              <li id="s_csz">${[
                response.data.city,
                response.data.state,
                response.data.zip,
              ].join(", ")}</li>
              <li class="listhdng">Email :</li>
              <li id="s_em">${response.data.email}</li>
              <li class="listhdng">Phone :</li>
              <li id="s_ph">${response.data.phone}</li>
            `;

          dynamicData.s_name = response.data.name;
          dynamicData.s_bid = response.data.b_id;
          dynamicData.s_afm = response.data.firm_name;
          dynamicData.s_fa = response.data.street_address;
          dynamicData.s_city = response.data.city;
          dynamicData.s_state = response.data.state;
          dynamicData.s_zip = response.data.zip;
          dynamicData.s_em = response.data.email;
          dynamicData.s_ph = response.data.phone;

          $(".modify-attorney-wrapper").addClass("d-flex");
          $(".modify-attorney-wrapper").removeClass("d-none");

          toastr.success("Attorney Added");
        } else {
          var str = "";
          $.each(response.errors, function (fieldName, errorMessages) {
            str += errorMessages + "<br>";
          });
          toastr.error(str);
        }
      },
    });
  });

  var dynamicData = {
    s_bid: "",
    s_afm: "",
    s_fa: "",
    s_city: "",
    s_state: "",
    s_zip: "",
    s_em: "",
    s_ph: "",
  };

  $("#update-attorney").on("click", function (e) {
    e.preventDefault();

    var s_name = $("#s_name_input").val();
    var s_bid = $("#s_bid_input").val();
    var s_afm = $("#s_afm_input").val();
    var s_fa = $("#s_fa_input").val();
    var s_city = $("#s_city_input").val();
    var s_state = $("#s_state_input").val();
    var s_zip = $("#s_zip_input").val();
    var s_em = $("#s_em_input").val();
    var s_ph = $("#s_ph_input").val();

    if (
      s_name === "" ||
      s_bid === "" ||
      s_afm === "" ||
      s_fa === "" ||
      s_city === "" ||
      s_state === "" ||
      s_zip === "" ||
      s_em === "" ||
      s_ph === ""
    ) {
      return toastr.error("Please fill in the fields carefully");
    } else {
      console.log($("#selected-attorney").val());
      var formData = new FormData();
      formData.append("s_id", $("#selected-attorney").val());
      formData.append("s_name", s_name);
      formData.append("s_bid", s_bid);
      formData.append("s_afm", s_afm);
      formData.append("s_fa", s_fa);
      formData.append("s_city", s_city);
      formData.append("s_state", s_state);
      formData.append("s_zip", s_zip);
      formData.append("s_em", s_em);
      formData.append("s_ph", s_ph);

      $.ajax({
        type: "POST",
        url: "update_attorney",
        data: formData,
        contentType: false,
        processData: false,
        success: (response) => {
          if (response) {
            var attorneyInfoList =
              document.getElementById("attorney-info-list");
            console.log(s_name);
            attorneyInfoList.innerHTML = `
              <li class="listhdng">Attorney Name & Bar ID:</li>
              <li id="s_bid">${s_name + " " + s_bid}</li>
              <li class="listhdng">Firm Name:</li>
              <li id="s_afm">${s_afm}</li>
              <li class="listhdng">Firm Address:</li>
              <li id="s_fa">${s_fa}</li>
              <li class="listhdng">City, State, Zip Code:</li>
              <li id="s_csz">${[s_city, s_state, s_zip].join(", ")}</li>
              <li class="listhdng">Email :</li>
              <li id="s_em">${s_em}</li>
              <li class="listhdng">Phone :</li>
              <li id="s_ph">${s_ph}</li>
            `;

            dynamicData.s_name = s_name;
            dynamicData.s_bid = s_bid;
            dynamicData.s_afm = s_afm;
            dynamicData.s_fa = s_fa;
            dynamicData.s_city = s_city;
            dynamicData.s_state = s_state;
            dynamicData.s_zip = s_zip;
            dynamicData.s_em = s_em;
            dynamicData.s_ph = s_ph;

            $("#modify-attorney").trigger("click");

            toastr.success("Attorney has been updated successfully");
          }
        },
      });
    }
  });

  $("#modify-attorney").on("change", function (e) {
    var checkbox = this;
    var attorneyInfoList = document.getElementById("attorney-info-list");

    if (checkbox.checked) {
      $("#update-attorney").removeClass("d-none");
      const text = $("#s_bid").html();
      const text2 = $("#s_csz").html();

      const parts = text.split(" ");
      const bid = parts[parts.length - 1];
      const name = parts.slice(0, parts.length - 1).join(" ");

      const parts2 = text2.split(", ");
      const zip = parts2[parts2.length - 1];
      const state = parts2[parts2.length - 2];
      const city = parts2[parts2.length - 3];

      dynamicData = {
        s_name: name,
        s_bid: bid,
        s_afm: $("#s_afm").html(),
        s_fa: $("#s_fa").html(),
        s_city: city,
        s_state: state,
        s_zip: zip,
        s_em: $("#s_em").html(),
        s_ph: $("#s_ph").html(),
      };
      // Replace list items with input boxes
      attorneyInfoList.innerHTML = `
            <li class="listhdng">Attorney Name & Bar ID:</li>
            <li>
              <div class="input-group">
                  <input style="flex: 2; type="text" class="form-control" id="s_name_input" placeholder="Enter Attorney Name" value="${dynamicData.s_name}">
                  <div class="input-group-append mr-2">
                  </div>
                  <input style="flex: 1; type="text" class="form-control" id="s_bid_input" placeholder="Enter Bar ID" value="${dynamicData.s_bid}">
              </div>
            </li>
            <li class="listhdng">Firm Name:</li>
            <li><input type="text" class="form-control" id="s_afm_input" placeholder="Enter Firm Name" value="${dynamicData.s_afm}"></li>
            <li class="listhdng">Firm Address:</li>
            <li><input type="text" class="form-control" id="s_fa_input" placeholder="Enter Firm Address" value="${dynamicData.s_fa}"></li>
            <li class="listhdng">City, State, Zip Code:</li>
            <li>
              <div class="input-group">
                  <input style="flex: 2; type="text" class="form-control" id="s_city_input" placeholder="Enter City" value="${dynamicData.s_city}">
                  <input style="flex: 1; type="text" class="form-control" id="s_state_input" placeholder="Enter State" value="${dynamicData.s_state}">
                  <input style="flex: 1; type="text" class="form-control" id="s_zip_input" placeholder="Enter Zip" value="${dynamicData.s_zip}">
              </div>
            </li>
            <li class="listhdng">Email :</li>
            <li><input type="text" class="form-control" id="s_em_input" placeholder="Enter Email" value="${dynamicData.s_em}"></li>
            <li class="listhdng">Phone :</li>
            <li><input type="text" class="form-control" id="s_ph_input" placeholder="Enter Phone" value="${dynamicData.s_ph}"></li>
        `;
    } else {
      $("#update-attorney").addClass("d-none");
      // Reset to default list items
      attorneyInfoList.innerHTML = `
            <li class="listhdng">Attorney Name & Bar ID:</li>
            <li id="s_bid">${dynamicData.s_name + " " + dynamicData.s_bid}</li>
            <li class="listhdng">Firm Name:</li>
            <li id="s_afm">${dynamicData.s_afm}</li>
            <li class="listhdng">Firm Address:</li>
            <li id="s_fa">${dynamicData.s_fa}</li>
            <li class="listhdng">City, State, Zip Code:</li>
            <li id="s_csz">${[
              dynamicData.s_city,
              dynamicData.s_state,
              dynamicData.s_zip,
            ].join(", ")}</li>
            <li class="listhdng">Email :</li>
            <li id="s_em">${dynamicData.s_em}</li>
            <li class="listhdng">Phone :</li>
            <li id="s_ph">${dynamicData.s_ph}</li>
        `;
    }
  });

  $("#att_select").change(function () {
    var name = $(this).val();

    if (name !== "") {
      $.ajax({
        type: "GET",
        url: "get_attorney/" + name,
        success: (response) => {
          if (response) {
            console.log(response.id);
            $("#selected-attorney").val(response.id);
            // console.log(response);
            $(".modify-attorney-wrapper").removeClass("d-none");
            $(".modify-attorney-wrapper").addClass("d-flex");
            $("#s_bid").text(response.name + " " + response.b_id);
            // $("#s_na").text(response.name);
            $("#s_afm").text(response.firm_name);
            $("#s_fa").text(response.street_address);
            $("#s_csz").text(
              [response.city, response.state, response.zip].join(", ")
            );
            $("#s_em").text(response.email);
            $("#s_ph").text(response.phone);
            toastr.success("Attorney has been set successfully");
          }
        },
      });
    } else {
      $(".modify-attorney-wrapper").addClass("d-none");
      $(".modify-attorney-wrapper").removeClass("d-flex");

      if ($("#modify-attorney").is(":checked")) {
        $("#modify-attorney").trigger("click");
      }

      $("#s_bid").text("-");
      $("#s_em").text("-");
      $("#s_ph").text("-");
      $("#s_afm").text("-");
      $("#s_fa").text("-");
      $("#s_csz").text("-");
    }
  });
});

$(document).ready(function (e) {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $("#case_form").submit(function (e) {
    e.preventDefault();
    let form = new FormData(this);

    if (!$("#no-attorney").prop("checked")) {
      if ($("#c_num").val() == "" || $(".jur_select").val() == "default") {
        return toastr.error("Please fill in fields carefully");
      }
    }

    $.ajax({
      type: "POST",
      url: "add_case",
      data: form,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#step-1-save-btn").prop("disabled", true);
        $("#step-1-save-btn").html(
          '<span id="spinner" class="fa fa-spinner fa-spin"></span> Wait'
        );
      },
      success: function (response) {
        // $.ajax({
        //   type: "GET",
        //   url: "get_party_all_c",
        //   dataType: "json",
        //   success: function (data) {
        //     $.each(data, function (index, record) {
        //       var rowId = "pa_" + record.id;
        //       $("#no_pa").hide();
        //       if ($("#" + rowId).length === 0) {
        //         $("#party_tbody").append(
        //           "<tr class='brdrrbtm text-center' id='" +
        //             rowId +
        //             "'><td><input type='checkbox' " +
        //             (record.l_client === "yes"
        //               ? "checked disabled"
        //               : "disabled") +
        //             "></td><td>" +
        //             record.name +
        //             "</td><td>" +
        //             record.role +
        //             "</td><td><div class='btnsct'><a href='javascript:void(0)' onclick='edit_party(" +
        //             record.id +
        //             ")' class='pencl'><i class='fa fa-pencil'></i></a><a href='javascript:void(0)' class='crss' onclick='del_party(" +
        //             record.id +
        //             ")'><i class='fa fa-times'></i></a></div></td></tr>"
        //         );
        //       }
        //     });
        //   },
        // });

        // $("#step2s").removeClass("active");
        // $("#step3s").addClass("active");
        // $("#step2").removeClass("show active");
        // $("#step3").addClass("show active");
        // $("#step2").attr("aria-selected", "false");
        // $("#step3").attr("aria-selected", "true");
        toastr.success("Case Added");

        window.location.reload();
      },
    });
  });

  $(".prev-btn").on("click", function (e) {
    e.preventDefault();

    $.ajax({
      type: "GET",
      url: "add_case_prev_step",
      success: (response) => {
        window.location.reload();
      },
    });
  });

  $("#c_num").change(function () {
    var ccase = $(this).val();
    $.ajax({
      type: "GET",
      url: "get_case/" + ccase,
      success: (response) => {
        if (response.id) {
          $("#c_ti").attr("readonly", "readonly");
          $("#c_ti").val(response.case_title);
          $("#c_ju").hide();
          $("#c_juii").css("display", "block");
          $("#c_jui").val(response.jurisdiction);
          $('#att_select option[value="' + response.attorney + '"]').attr(
            "selected",
            "selected"
          );

          $("#selected-attorney").val(response.attorneyRow.id);
          $.ajax({
            type: "GET",
            url: "get_attorney/" + response.attorney,
            success: (response) => {
              if (response) {
                $(".modify-attorney-wrapper").addClass("d-flex");
                $(".modify-attorney-wrapper").removeClass("d-none");

                $("#s_bid").text(response.name + " " + response.b_id);
                // $("#s_na").text(response.name);
                $("#s_afm").text(response.firm_name);
                $("#s_fa").text(response.street_address);
                $("#s_csz").text(
                  [response.city, response.state, response.zip].join(", ")
                );
                $("#s_em").text(response.email);
                $("#s_ph").text(response.phone);
              }
            },
          });
        } else {
          $("#c_ti").removeAttr("readonly", "readonly");
          $("#c_ti").val("");
          $("#c_ju").show();
          $("#c_juii").css("display", "none");
          $("#c_jui").val("");
          $('#att_select option[value="default"]').attr("selected", "selected");
          $("#s_bid").text("-");
          $("#s_na").text("-");
          $("#s_em").text("-");
          $("#s_ph").text("-");
          $("#s_afm").text("-");
          $("#s_fa").text("-");
          $("#s_csz").text("-");
        }
      },
    });
  });
});

function resetModalFields() {
  document.getElementById("party_modal_org_name").value = "";
  document.getElementById("p_role").value = "";
  document.getElementById("p_lclient_no").checked = true;
  document.getElementById("p_type_p").checked = true;
  document.getElementById("party_modal_org_fname").style.display = "block";
  document.getElementById("party_modal_org_mid_name").style.display = "block";
  document.getElementById("party_modal_org_last_name").style.display = "block";
  document.getElementById("party_modal_org_name").style.display = "none";
  document.getElementById("party_modal_org_suffix").style.display = "block";
  document.getElementById("party_modal_billing_code").style.display = "none";
  $("#addparty").modal("hide");
}

function addPartyModalChange(type) {
  if (type == "org") {
    document.getElementById("party_modal_org_fname").style.display = "none";
    document.getElementById("party_modal_org_mid_name").style.display = "none";
    document.getElementById("party_modal_org_last_name").style.display = "none";
    document.getElementById("party_modal_org_name").style.display = "block";
    document.getElementById("party_modal_org_suffix").style.display = "none";
  } else {
    document.getElementById("party_modal_org_fname").style.display = "block";
    document.getElementById("party_modal_org_mid_name").style.display = "block";
    document.getElementById("party_modal_org_last_name").style.display =
      "block";
    document.getElementById("party_modal_org_name").style.display = "none";
    document.getElementById("party_modal_org_suffix").style.display = "block";
  }
}

$(document).ready(function (e) {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $("#add_party_form").submit(function (e) {
    e.preventDefault();
    let form = new FormData(this);
    $.ajax({
      type: "POST",
      url: "add_party",
      data: form,
      contentType: false,
      processData: false,
      success: (response) => {
        if (response.status) {
          // $("#add_party_form")[0].reset();
          // resetModalFields();
          // $("#no_pa").hide();
          // $("#party_tbody").append(
          //   "<tr class='brdrrbtm text-center' id='pa_" +
          //     response.data.id +
          //     "'><td><input  onclick='leadClientChange(this, event, " +
          //     response.data.id +
          //     ")' type='checkbox' " +
          //     (response.data.l_client === "yes" ? "checked disabled" : "") +
          //     "></td><td>" +
          //     response.data.name +
          //     "</td><td>" +
          //     response.data.role +
          //     "</td><td><div class='btnsct'><a href='javascript:void(0)' onclick='edit_party(" +
          //     response.data.id +
          //     ")' class='pencl'><i class='fa fa-pencil' ></i></a><a href='javascript:void(0)' class='crss' onclick='del_party(" +
          //     response.data.id +
          //     ")'><i class='fa fa-times'></i></a></div></td></tr>"
          // );

          toastr.success("Party Added");

          window.location.reload();
        } else {
          var str = "";
          $.each(response.errors, function (fieldName, errorMessages) {
            str += errorMessages + "<br>";
          });
          toastr.error(str);
        }
      },
    });
  });
});

$(document).ready(function (e) {
  var elementToUpdateServe = "";
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $("#edit_party_formp").submit(function (e) {
    e.preventDefault();
    let form = new FormData(this);
    $.ajax({
      type: "POST",
      url: "edit_party",
      data: form,
      contentType: false,
      processData: false,
      success: (response) => {
        console.log(response);
        if (response.status) {
          // $("#editpartyp").modal("toggle");
          // $("#party_tbody").append(
          //   "<tr class='text-center'><td><input onclick='leadClientChange(this, event, " +
          //     response.data.id +
          //     ")' type='checkbox' " +
          //     (response.data.l_client === "yes" ? "checked disabled" : "") +
          //     "></td><td>" +
          //     response.data.name +
          //     "</td><td>" +
          //     response.data.role +
          //     "</td><td><div class='btnsct'><a href='javascript:void(0)' onclick='edit_party(" +
          //     response.data.id +
          //     ")' class='pencl'><i class='fa fa-pencil' ></i></a><a href='javascript:void(0)' class='crss' onclick='del_party(" +
          //     response.data.id +
          //     ")'><i class='fa fa-times'></i></a></div></td></tr>"
          // );
          toastr.success("Party Updated");
          window.location.reload();
        } else {
          var str = "";
          $.each(response.errors, function (fieldName, errorMessages) {
            str += errorMessages + "<br>";
          });
          toastr.error(str);
        }
      },
    });
  });
  $("#edit_party_formo").submit(function (e) {
    e.preventDefault();
    let form = new FormData(this);
    $.ajax({
      type: "POST",
      url: "edit_party",
      data: form,
      contentType: false,
      processData: false,
      success: (response) => {
        console.log(response);
        if (response.status) {
          // $("#editpartyo").modal("toggle");
          // $("#party_tbody").append(
          //   "<tr class='text-center'><td><input onclick='leadClientChange(this, event, " +
          //     response.data.id +
          //     ")' type='checkbox' " +
          //     (response.data.l_client === "yes" ? "checked disabled" : "") +
          //     "></td><td>" +
          //     response.data.name +
          //     "</td><td>" +
          //     response.data.role +
          //     "</td><td><div class='btnsct'><a href='javascript:void(0)' onclick='edit_party(" +
          //     response.data.id +
          //     ")' class='pencl'><i class='fa fa-pencil' ></i></a><a href='javascript:void(0)' class='crss' onclick='del_party(" +
          //     response.data.id +
          //     ")'><i class='fa fa-times'></i></a></div></td></tr>"
          // );
          toastr.success("Party Updated");

          window.location.reload();
        } else {
          var str = "";
          $.each(response.errors, function (fieldName, errorMessages) {
            str += errorMessages + "<br>";
          });
          toastr.error(str);
        }
      },
    });
  });
});

function edit_party(id) {
  $.get({
    url: "get_party/" + id,
    success: function (response) {
      if (response.type == "person") {
        $("#editpartyp").modal("toggle");
        $("#pe_id").val(response.id);
        $("#pe_name").val(response.name);
        $('#pe_role option[value="' + response.role + '"]').attr(
          "selected",
          "selected"
        );
        $('#pe_sfx option[value="' + response.sfx + '"]').attr(
          "selected",
          "selected"
        );
        if (response.l_client == "no") {
          $("input[name='pe_lclient'][value='no']").prop("checked", true);
        } else {
          $("input[name='pe_lclient'][value='yes']").prop("checked", true);
          $("#pparty_modal_billing_code").show();
          $("#pep_bcode").val(response.b_code);
        }
      } else {
        $("#editpartyo").modal("toggle");
        $("#po_id").val(response.id);
        $("#pe_nam").val(response.name);
        $('#pe_role option[value="' + response.role + '"]').attr(
          "selected",
          "selected"
        );
        if (response.l_client == "no") {
          $("input[name='pe_lclient'][value='no']").prop("checked", true);
        } else {
          $("input[name='pe_lclient'][value='yes']").prop("checked", true);
          document.getElementById("ppparty_modal_billing_code").style.display =
            "block";
          $("#pe_bcode").val(response.b_code);
        }
      }
    },
  });
}

function addPartyLeadClient(data) {
  if (data == "yes") {
    document.getElementById("party_modal_billing_code").style.display = "block";
  } else {
    document.getElementById("party_modal_billing_code").style.display = "none";
  }
}

function editPartyLeadClient(data) {
  if (data == "yes") {
    document.getElementById("pparty_modal_billing_code").style.display =
      "block";
  } else {
    document.getElementById("pparty_modal_billing_code").style.display = "none";
  }
}

function editPartyLeadCliento(data) {
  if (data == "yes") {
    document.getElementById("ppparty_modal_billing_code").style.display =
      "block";
  } else {
    document.getElementById("ppparty_modal_billing_code").style.display =
      "none";
  }
}

function del_party(id) {
  swal({
    title: "Are you sure To Delete?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      let _token = $("input[name=_token]").val();
      $.ajax({
        url: "del_party/" + id,
        type: "DELETE",
        data: {
          _token: _token,
        },
        success: function (response) {
          if (response) {
            $("#pa_" + id).remove();
            toastr.error("Party was Deleted.");
          }
        },
      });
    } else {
      swal("Your Record is Safe.", {
        icon: "success",
      });
    }
  });
}

function addNewPartyToServe(elm) {
  elementToUpdateServe = elm;
  let _token = $("input[name=_token]").val();
  $.ajax({
    url: "check_party/" + $(elm).val(),
    type: "GET",
    data: {
      _token: _token,
    },
    success: function (response) {
      if (response) {
        $(elm).parent().next().next().find("select").val("-");
        $(elm).parent().next().next().next().find("input").val("");

        console.log($(elm).parent().next().next());
        if (response.role_type != null) {
          $(elm)
            .parent()
            .parent()
            .find(".servee-role-type select")
            .val(response.role_type)
            .addClass("custom-readonly")
            .attr("readonly", true);
        } else {
          $(elm)
            .parent()
            .parent()
            .find(".servee-role-type select")
            .removeClass("custom-readonly")
            .attr("readonly", false);
        }
      }
    },
    error: function (xhr, status, error) {
      $(elm)
        .parent()
        .parent()
        .find(".servee-role-type select")
        .removeClass("custom-readonly")
        .attr("readonly", false);

      $(elm).parent().next().next().find("select").val("-");
      $(elm).parent().next().next().next().find("input").val("");
    },
  });

  if ($(elm).val() == "new") {
    add_free_serve();
  }
}
$(document).ready(function () {
  $("#p_role").on("change", function (e) {
    if ($(this).val() == "Defendant") {
      $('input[name="role_type"][value="defendant"]').prop("checked", true);
      $('input[name="role_type"]').prop("readonly", true);
    }

    else if ($(this).val() == "Plaintiff") {
      $('input[name="role_type"]').prop("readonly", true);
      $('input[name="role_type"][value="plaintiff"]').prop("checked", true);
    }
     else {
      $('input[name="role_type"]').prop("readonly", false);
     }

    
  });

  $(".dynamic_se").select2({
    tags: true,
    selectOnClose: true,
  });

  function initializeSelect2(selectElementObj) {
    selectElementObj.select2({
      tags: true,
      selectOnClose: true,
    });

    selectElementObj.on("select2:select", function (e) {
      // Triggered when a tag is selected (existing or newly created)
      var selectedTag = e.params.data.text;

      addNewPartyToServe(this);

      // Run your custom function here with the selectedTag
      // Example: customFunction(selectedTag);
    });
  }

  $(".serve-party-name").each(function () {
    initializeSelect2($(this));
  });

  $("#no_of_party").on("change", function () {
    var rowCount = parseInt($(this).val());
    var currentRowCount = $("#myTable tbody tr").length;
    var totalRowCount = currentRowCount + rowCount;
    if (totalRowCount > 15) {
      toastr.error(
        "You can add only " + (currentRowCount - rowCount) + " Serve."
      );
    } else {
      $("#no_ser").hide();
      $("#serve_table").empty();
      for (var i = 0; i < rowCount; i++) {
        var html =
          "<tr id='serve_row_" +
          i +
          "'><td><select class='form-control serve-party-name'   name='party[]'><option value='-'>Select...</option>  @php $par = DB::table('parties')->get(); @endphp @foreach ($par as $pars) <option value='{{ $pars->name }}'>{{ $pars->name }}</option>@endforeach</select></td><td class='servee-role-type'><select class='form-control' name='servee_role_type[]'><option value='defendant'>Defendant</option><option value='plaintiff' >Plaintiff</option><option value='witness'>Witness</option><option value='deponent'>Deponent</option></select></td><td><select onChange='roleChangeUpdate(this)' class='form-control role-select' name='role[]'><option value='-'>Select...</option><option value='Association or Partnership'>Association or Partnership</option><option value='Authorized Person'>Authorized Person</option><option value='Business Organization, Form Unknown'>Business Organization, Form Unknown</option><option value='Corporation'>Corporation</option><option value='Defunct Corporation'>Defunct Corporation</option><option value='Estate'>Estate</option><option value='Fictitious'>Fictitious</option><option value='Individual'>Individual</option><option value='Joint Stock Company/Association'>Joint Stock Company/Association</option><option value='Minor'>Minor</option><option value='Occupant Prejudgment Claim'>Occupant Prejudgment Claim</option><option value='Public Entity'>Public Entity</option><option value='Sole Proprietorship'>Sole Proprietorship</option><option value='Trust'>Trust</option></select></td><td><input type='text' class='form-control' name='agent[]' placeholder='Registered Agent'></td><td width='5%'><div class='btnsct'><a href='javascript:void(0)' class='pencl' style='background-color: red; color:white;' onclick='remove_more(" +
          i +
          ")'><i class='fa fa-times' aria-hidden='true'></i></a></div></td></tr>";
        $("#serve_table").append(html);

        initializeSelect2($("#serve_row_" + i + " .serve-party-name"));
        $.ajax({
          type: "GET",
          url: "get_party_all",
          dataType: "json",
          success: function (data) {
            var partySelect = $("#serve_table").find("select[name='party[]']");
            partySelect.empty();
            partySelect.append("<option value='-'>Select...</option>");
            // partySelect.append("<option value='new'>New</option>");
            $.each(data, function (index, item) {
              partySelect.append($("<option>").text(item.name).val(item.name));
            });
          },
          error: function (xhr, status, error) {
            console.error("Error fetching data: " + error);
          },
        });
      }
    }
  });
});

function tab_documents() {
  $("#step3s").removeClass("active");
  $("#step4s").addClass("active");
  $("#step3").removeClass("show active");
  $("#step4").addClass("show active");
  $("#step3").attr("aria-selected", "false");
  $("#step4").attr("aria-selected", "true");
}
$(".dynamic").change(function () {
  var id = $(this)
    .attr("id")
    .replace(/[^0-9]/g, "");
  var category = $(this).val();
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  // Check if the selected category is "-"
  if (category === "-") {
    // Hide the second dropdown and clear its options
    $("#cddfs" + id).addClass("col-md-12");
    $("#cddfs" + id).removeClass("col-md-4");
    $("#cddss" + id).hide();
    $("#secondSelec" + id).empty();
  } else {
    // Show the second dropdown
    $("#cddfs" + id).removeClass("col-md-12");
    $("#cddfs" + id).addClass("col-md-4");
    $("#cddss" + id).show();

    // Make the AJAX request to populate the second dropdown
    $.ajax({
      type: "POST",
      url: "get-options",
      data: { category: category },
      success: function (data) {
        $("#secondSelec" + id).empty();

        // Add the "Select Title" option as the first option
        $("#secondSelec" + id).append(new Option("Select Document", "-"));

        $.each(data, function (index, document) {
          $("#secondSelec" + id).append(new Option(document, document));
        });
      },
    });
  }
});
$(".dynamic_sd").change(function () {
  var id = $(this)
    .attr("id")
    .replace(/[^0-9]/g, "");
  var category = $(this).val();
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  if (category === "-") {
    $("#cdfs" + id).addClass("col-md-12");
    $("#cdfs" + id).removeClass("col-md-4");
    $("#cdss" + id).hide();
    $("#second" + id).empty();
  } else {
    $("#cdfs" + id).removeClass("col-md-12");
    $("#cdfs" + id).addClass("col-md-4");
    $("#cdss" + id).show();
    $.ajax({
      type: "POST",
      url: "get-options",
      data: { category: category },
      success: function (data) {
        $("#second" + id).empty();

        $("#second" + id).append(new Option("Select Title", "-"));

        $.each(data, function (index, document) {
          $("#second" + id).append(new Option(document, document));
        });
      },
    });
  }
});

function d_upload(id) {
  var s_no = $("#s_id_" + id).val();
  var type = $("#firstSelec" + id).val();
  var title = $("#secondSelec" + id).val();
  var fileInput = $("#d_file_" + id)[0];
  var file = fileInput.files[0];
  if (title === "-") {
    toastr.error("Please select a document.");
    return;
  }
  if (!file) {
    toastr.error("Please select a file.");
    return;
  }
  var formData = new FormData();
  formData.append("s_no", s_no);
  formData.append("title", title);
  formData.append("file", file);
  formData.append("type", type);
  $.ajax({
    type: "POST",
    url: "add_d",
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () {
      $("#d_upload_" + id).prop("disabled", true);
      $("#d_upload_" + id).html(
        '<span id="spinner" class="fa fa-spinner fa-spin"></span>'
      );
    },
    success: function (response) {
      // $("#cddfs" + id).removeClass("col-md-3");
      // $("#cddfs" + id).addClass("col-md-12");
      // $("#cddss" + id).remove();
      $('.document-type-select option[value="' + type + '"]').attr(
        "selected",
        "selected"
      );

      $(".document-name-wrapper").show();
      $(".court-defined-document").addClass("col-md-4");
      $(".court-defined-document").removeClass("col-md-12");
      $(".document-type-select").attr("disabled", true);

      // $("#secondSelec" + id)
      //   .val("-")
      //   .trigger("change.select2");
      $("#d_file_" + id).val("");
      $("#s_d_table_" + id).append(
        "<tr id='s_d_r_" +
          response.id +
          "' ><td><a style='color: red; text-decoration:none;' href='uploads/" +
          response.document +
          "' target='_blank'>" +
          response.document +
          "</a></td><td width='5%'><div class='btnsct'><a href='javascript:void(0)' class='pencl' style='background-color: red; color:white;' onclick='del_document(" +
          response.id +
          ")'><i class='fa fa-times' aria-hidden='true'></i></a> </div> </td></tr>"
      );
      $("#dd").append(
        "<tr><td>" +
          response.s_name.p_t_serve +
          "</td><td><a style='color: red; text-decoration:none;' href='uploads/" +
          response.document +
          "' target='_blank'>" +
          response.document +
          "</a></td></tr>"
      );
      $("#d_upload").prop("disabled", false);
      $("#d_upload").html(
        '<i class="fa fa-cloud-upload mr-1"aria-hidden="true"></i>'
      );

      $.ajax({
        type: "POST",
        url: "get-options",
        data: { category: type },
        success: function (data) {
          $(".dynamic_se").empty();

          // Add the "Select Title" option as the first option
          $(".dynamic_se").append(new Option("Select Document", "-"));

          $.each(data, function (index, document) {
            $(".dynamic_se").append(new Option(document, document));
          });
        },
      });

      toastr.success("Document inserted successfully.");
      // location.reload();
    },
    error: function (xhr) {
      console.log(xhr.responseText);
    },
    complete: function () {
      // After the request is complete (whether it's successful or not)
      $("#d_upload_" + id).prop("disabled", false);
      $("#d_upload_" + id).html(
        '<i class="fa fa-cloud-upload mr-1" aria-hidden="true"></i>'
      );
    },
  });
}
function sd_d_upload(id) {
  var title = $("#second" + id).val();
  var type = $("#first" + id).val();
  var fileInput = $("#sd_d_file_" + id)[0];
  var file = fileInput.files[0];
  if (title === "-") {
    toastr.error("Please select a document.");
    return;
  }
  if (!file) {
    toastr.error("Please select a file.");
    return;
  }
  var formData = new FormData();
  formData.append("title", title);
  formData.append("file", file);
  formData.append("type", type);
  $.ajax({
    type: "POST",
    url: "add_dd",
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function () {
      $("#sd_d_upload_" + id).prop("disabled", true);
      $("#sd_d_upload_" + id).html(
        '<span id="spinner" class="fa fa-spinner fa-spin"></span>'
      );
    },
    success: function (response) {
      // $("#cdfs" + id).removeClass("col-md-3");
      // $("#cdfs" + id).addClass("col-md-12");
      // $("#cdss" + id).remove();
      $("#first" + id + ' option[value="' + type + '"]').attr(
        "selected",
        "selected"
      );
      $("#first" + id).attr("disabled", true);
      $("#second" + id + ' option[value="-"]').attr("selected", "selected");
      $("#second" + id)
        .val("-")
        .trigger("change.select2");
      $("#sd_d_file_" + id).val("");
      $("#sd_s_d_table_" + id).append(
        "<tr id='s_d_r_" +
          response.id +
          "'><td><a style='color: red; text-decoration:none;' href='uploads/" +
          response.document +
          "' target='_blank'>" +
          response.document +
          "</a></td><td width='5%'><div class='btnsct'><a href='javascript:void(0)' class='pencl' style='background-color: red; color:white;' onclick='del_document(" +
          response.id +
          ")'><i class='fa fa-times' aria-hidden='true'></i></a> </div> </td></tr>"
      );
      $("#dd").append(
        "<tr ><td>-</td><td><a style='color: red; text-decoration:none;' href='uploads/" +
          response.document +
          "' target='_blank'>" +
          response.document +
          "</a></td></tr>"
      );
      $("#sd_d_upload_").prop("disabled", false);
      $("#sd_d_upload_").html(
        '<i class="fa fa-cloud-upload mr-1"aria-hidden="true"></i>'
      );
      toastr.success("Document inserted successfully.");
      // location.reload();
    },
    error: function (xhr) {
      console.log(xhr.responseText);
    },
    complete: function () {
      // After the request is complete (whether it's successful or not)
      $("#sd_d_upload_" + id).prop("disabled", false);
      $("#sd_d_upload_" + id).html(
        '<i class="fa fa-cloud-upload mr-1" aria-hidden="true"></i>'
      );
    },
  });
}

function del_document(id) {
  swal({
    title: "Are you sure To Delete?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      let _token = $("input[name=_token]").val();
      $.ajax({
        url: "del_document/" + id,
        type: "DELETE",
        data: {
          _token: _token,
        },
        success: function (response) {
          console.log(id, $("#s_d_r_" + id).length);
          if (response) {
            if ($("#ss_d_r_" + id).length) {
              $("#ss_d_r_" + id).remove();
            }
            if ($("#s_d_r_" + id).length) {
              $("#s_d_r_" + id).remove();
            }
            if ($("#ddd" + id).length) {
              $("#ddd" + id).remove();
            }
            toastr.error("Document was Deleted");
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          toastr.error("Error deleting the document.");
        },
      });
    } else {
      swal("Your Record is Safe.", {
        icon: "success",
      });
    }
  });
}

function deleteOrder(elm, id) {
  swal({
    title: "Are you sure To Delete?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type: "delete",
        url: "del-order/" + id,
        success: (response) => {
          if (response) {
            // $(elm).parent().parent().remove();

            toastr.success("Order deleted successfully");

            window.location.reload();
          }
        },
      });
    } else {
      swal("Your Record is Safe.", {
        icon: "success",
      });
    }
  });
}

$(document).ready(function (e) {
  let table = new DataTable("#draft-order-table", {
    responsive: true,
    searching: true,
    wrap: true,
  });

  let table2 = new DataTable("#pending-order-table", {
    responsive: true,
    searching: true,
    wrap: true,
  });

  $("#addressType").on("change", function (e) {
    e.preventDefault();

    if ($(this).val() == "Residence") {
      $("#business-name-wrapper").hide();
    } else {
      $("#business-name-wrapper").show();
    }
  });

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $("#add_address").on("submit", function (e) {
    e.preventDefault();
    var form = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "upd_serve",
      data: form,
      beforeSend: function () {
        $("#address-save-btn").prop("disabled", true);
        $("#address-save-btn").html(
          '<span id="spinner" class="fa fa-spinner fa-spin"></span> Wait'
        );
      },
      success: (response) => {
        if (response) {
          toastr.success("Servee Info Added");
          window.location.reload();
        }
      },
    });
  });
});

function draft() {
  $.ajax({
    type: "get",
    url: "save-as-draft",
    beforeSend: function () {
      $(".save-as-draft").prop("disabled", true);
      $(".save-as-draft").html(
        '<span id="spinner" class="fa fa-spinner fa-spin"></span> Wait'
      );
    },
    success: (response) => {
      window.location.href = "/draft-order";
    },
  });
}

$(document).ready(function (e) {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });

  $(".optradio").click(function () {
    var type = $(this).data("type");
    var index = $(this).data("index");
    var key = $(this).data("key");
    $("#attempt_type_" + index + "_" + key).val(type);
  });

  $("#order_details").on("submit", function (e) {
    e.preventDefault();
    var form = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "final_step",
      data: form,
      success: (response) => {
        // window.location.reload();
      },
      error: () => {},
    });
  });
});

// function draft() {
//   $.ajaxSetup({
//     headers: {
//       "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//     },
//   });
//   var form = $("#order_details").serialize();
//   $.ajax({
//     type: "POST",
//     url: "order_draft",
//     data: form,
//     success: (response) => {
//       if (response) {
//         sessionStorage.removeItem("step3");
//         toastr.success("Order Drafted");
//         setTimeout(function () {
//           location.reload();
//         }, 300);
//       }
//     },
//   });
// }
