jQuery(document).ready(function($) {
    // Function to add new video row
    $('#add-video-slide').on('click', function() {
        var $table = $('#video-slides-table');
        var rowCount = $table.find('tr').length;
        var index = rowCount - 1; // Adjust to match the current number of rows

        // Create a new row with empty fields
        var newRow = `
            <tr>
                <td>
                    <label for="video_slider_videos[${index}][title]">Title:</label>
                    <input type="text" id="video_slider_videos[${index}][title]" name="video_slider_videos[${index}][title]" value="" />
                </td>
                <td>
                    <input type="text" id="video_slider_videos[${index}][link]" name="video_slider_videos[${index}][link]" value="" />
                </td>
                <td>
                    <label for="video_slider_videos[${index}][thumbnail]">Thumbnail URL:</label>
                    <input type="text" id="video_slider_videos[${index}][thumbnail]" name="video_slider_videos[${index}][thumbnail]" value="" />
                </td>
                <td>
                    <button type="button" class="remove-video-slide button">Remove</button>
                </td>
            </tr>
        `;

        $table.append(newRow);
    });

    // Function to remove video row
    $(document).on('click', '.remove-video-slide', function() {
        $(this).closest('tr').remove();
    });
});
