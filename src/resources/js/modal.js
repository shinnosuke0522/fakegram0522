$('#likesModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var likes = button.data('post');
    var modal = $(this);
    console.log('hello');
    modal.find('.modal-title').text('Like: ' + string(likes[likes_count]));
    modal.find('.modal-body').val(likes);
})