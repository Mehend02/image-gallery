<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="mx-5">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
    <div class="mt-5">
        <label for="folder" class="form-label fs-5">Choose a folder into which you'd like to upload the image.</label>
        <select name="folder" id="folder" class="form-select" aria-label="Choose a Folder">
            <option value="--select--">--Select a Folder--</option>
            <option value="people">People</option>
            <option value="pets">Pets</option>
            <option value="vacation">Vacation</option>
            <option value="miscellaneous">Miscellaneous</option>
        </select>
    </div>
    <p class="mt-4 fs-5">Choose the image you'd like add to the gallery.</p>
    <div class="mt-3 mb-5">
        <input type="file" name="file_upload" accept=".jpg, .jpeg, .png, .gif" class="btn ps-0 me-3 mt-1" required>
        <input type="submit" name="submit" value="Upload" class="btn btn-success mt-1">
    </div>
</form>