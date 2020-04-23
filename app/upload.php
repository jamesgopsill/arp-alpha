
<!DOCTYPE html>
<html>
<?php echo(file_get_contents("includes/head.html")); ?>

<body>
  <?php echo(file_get_contents("includes/navbar.html")); ?>

  <div class="container">
    <div class="card">
      <div class="card-body">
        
        <h5 class="card-title">Upload Print</h5>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Name</span>
          </div>
          <input id="owner" type="text" class="form-control" value="Test">
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">E-Mail</span>
          </div>
          <input id="email" type="email" class="form-control" value="test@test.com">
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Upload</span>
          </div>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="gc" >
            <label class="custom-file-label" for="gc" id="gcname">Choose file</label>
          </div>
        </div>

        <p><i>File Information</i></p>

        <dl class="row">
          
          <dt class="col-sm-4">Gcode Flavour</dt>
          <dd class="col-sm-8" id="gcflavour">[]</dd>

          <dt class="col-sm-4">File size</dt>
          <dd class="col-sm-8" id="gcsize">[]</dd>

          <dt class="col-sm-4">Material</dt>
          <dd class="col-sm-8" id="gcmaterial">[]</dd>

          <dt class="col-sm-4">Filament required (mm)</dt>
          <dd class="col-sm-8" id="gclength">[]</dd>

        </dl>

        <hr />

        <button class="btn btn-primary" id="submit" style="display:none;">Submit Print</button>

        <div id="upload-error" style="display:none;">
          <p><span class="badge badge-pill badge-warning">Error:</span> Please enter your name and email.</p>
        </div>
        <div id="error" style="display:none;">
          <p><span class="badge badge-pill badge-warning">Error</span></p>
        </div>
        <button class="btn btn-primary" id="submit" style="display:none;">Submit Print</button>
        <div id="progress" style="display:none;">
          <div class="spinner-border text-primary"></div>
          Uploading print information
        </div>
        <div id="upload-success" style="display:none;">
          <span class="badge badge-pill badge-success">Print Submitted</span>
        </div>

      </div>
    </div>
  </div>

  <?php echo(file_get_contents("includes/footer.html")); ?>
</body>

<?php echo(file_get_contents("includes/bootstrap-scripts.html")); ?>


<script>

var uploadData = {
  email: "",
  owner: "",
  gcname: "",
  gcsize: "",
  gclength: "",
  gcmaterial: "",
  gcflavour: "",
  gcode: ""
}

$("document").ready(() => {

  // Add the listener for the gcode file being added by the user
  $("#gc").change((event) => {
    console.log("File Selected");

    var file = event.target.files[0];
    $("#gcname").html(file.name);
    uploadData.gcname = file.name;
    $("#gcsize").html(file.size);
    uploadData.gcsize = file.size;

    $("#gcflavour").html("<small><div class=\"spinner-border text-primary\"></div></small>");
    $("#gclength").html("<small><div class=\"spinner-border text-primary\"></div></small>");
    $("#gcmaterial").html("<small><div class=\"spinner-border text-primary\"></div></small>");

    var reader = new FileReader();
    reader.onload = () => {
      var gcode = reader.result;
      uploadData.gcode = gcode;

      // console.log(gcode)

      if (gcode.includes("Slic3r")) {

        uploadData.gcflavour = "slic3r"
        $("#gcflavour").html(uploadData.gcflavour)

         // Filament used regex
        var filamentUsedRegEx = /filament used = ([\d\.]+)/g;
        var filamentUsedMatches = filamentUsedRegEx.exec(gcode);
        console.log(filamentUsedMatches[1])
        $("#gclength").html(filamentUsedMatches[1]);
        uploadData.gclength = filamentUsedMatches[1];

        // Filament material
        var filamentTypeRegEx = /filament_type = (\w+)/g;
        var filamentTypeMatches = filamentTypeRegEx.exec(gcode);
        $("#gcmaterial").html(filamentTypeMatches[1]);
        uploadData.gcmaterial = filamentTypeMatches[1];

        $("#submit").show();

      } else {
        $("#gclength").html("[]");
        $("#gcmaterial").html("[]");
      }

    }
    // Read in the image file as a data URL.
    reader.readAsText(file);
  })


  // This handles the submission of the form
  $("#submit").click(function(event) {
    $("#submit").hide();
    $("#progress").show();

    if ($("#owner").val() && $("#email").val()) {
      uploadData.owner = $("#owner").val();
      uploadData.email = $("#email").val();

      fetch("./api/post-print.php", {
        method: "POST",
        body: JSON.stringify(uploadData),
        headers: { 
          "Content-Type": "application/json" 
        }
      })
      .then(response => response.json())
      .then(json => {
        console.log(json)
        if (json.result == "success") {
          $("#progress").hide();
          $("#upload-success").show();
          $("#submit").hide();
        } else {
          $("#progress").hide();
          $("#submit").show();
          $("#error").show();
        }
      })
      .catch(err => console.error(err))
    } else {
       // There is an error with the email or user name
       $("#progress").hide();
      $("#upload-error").show();
      $("#submit").show();
    }
  })
})

</script>



</html>