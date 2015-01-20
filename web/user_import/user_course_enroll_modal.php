<!-- Button trigger modal
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>
 -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select course to enroll user(s) to</h4>
      </div>
      <div class="modal-body">

<table class='table table-condensed'>
<thead>
<th>Org</th>
<th>Course</th>
</thead>
<tbody>
<?php
foreach ($edxApp->courseids() as $courseId) {
    $ORG=explode("/",$courseId)[0];
    echo "<tr>";
    echo "<td>$ORG";
    echo "<td><a href=#enroll id=course title='$courseId'>".ucfirst(strtolower($edxApp->courseName($courseId)));

    //$footer[]="<option value='$courseId'>".ucfirst(strtolower($edxApp->courseName($courseId)))."</option>";
}
?>
</tbody>
</table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

