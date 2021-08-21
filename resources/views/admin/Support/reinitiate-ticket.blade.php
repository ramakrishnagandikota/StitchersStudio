<form id="support-reply">
    <div class="col-lg-12" id="reply-summernote">
        <div class="form-group">
            <label for="int1">Your Response</label>
            <input type="hidden" name="reinitiated" value="1">
            <input type="hidden" id="support_id" name="support_id" value="{{ base64_encode($support->id) }}">
            <input type="hidden" id="ticket_id" name="ticket_id" value="{{ base64_encode($support->ticket_id) }}">
            <textarea class="hint2mention summernote" name="support_comment" id="support_comment"></textarea>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 style="color: #c14d7d;text-decoration: underline;cursor: pointer;" onclick="showAttachments()">Add Attachments</h5>
            </div>
            <div class="card-block attachment-box">
                <!-- <div class="sub-title">Example 1</div> -->
                <input type="file" name="files[]" id="filer_input1" multiple="multiple">
            </div>
        </div>
    </div>
    <div class="col-sm-12 m-t-20">
        <div class="text-center m-b-10">
            <button type="submit" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" >Reply to ticket</button>
        </div>
    </div>
</form>

<script type="text/javascript" src="{{asset('resources/assets/files/assets/pages/filer/support-fileupload.init.js')}}"></script>
