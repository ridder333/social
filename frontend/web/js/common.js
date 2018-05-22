var loadingMessagesFlag;
var page;
var pageCount;

function checkNewMessages() {
    //отмечаем прочитанные сообщения
    $('.not-read').removeClass('not-read');
    $('.not-read-label').html('');
    
    // проверяем новые сообщения и выводим
    var id = $('[id=message-to_user_id]').val();
    var name = $('[id=to_user_name]').html();
    
    $.ajax({
        url:'/message/check-new-messages',
        type:'POST',
        dataType: 'json',
        data:{'from_user_id':id},
        success: function(data){
            if(data.length > 0){
                $('.not-chat').remove();
            }
            var i;
            var newMessageDiv = "";
            for (i = 0; i < data.length; i++) {
                newMessageDiv = '<div class="message message-to not-read">' +
                                    '<div class="message-author">' +
                                        '<a href="/user/' + id + '">' +
                                            name + '</a>' +
                                        '<span class="not-read-label">(не прочитано)</span>' +
                                    '</div>' +
                                    data[i].text +
                                    '<div class="message-date">' + data[i]['created_at'] + '</div>' + 
                                 '</div>';
                $( ".chat" ).append(newMessageDiv);
            }
        }
    });
}

function loadMessages() {
    // защита от повторных нажатий
    if (!loadingMessagesFlag) {
        // выставляем блокировку
        loadingMessagesFlag = true;
 
        // отображаем анимацию загрузки
        $('.message-index .loading').show();
 
        $.ajax({
            type: 'post',
            url: window.location.href,
            data: {
                // передаем номер нужной страницы методом POST
                'page': page - 1,
            },
            success: function(data) {
                // увеличиваем номер текущей страницы и снимаем блокировку
                page--;                            
                loadingMessagesFlag = false;                            
 
                // прячем анимацию загрузки
                $('.message-index .loading').hide();
 
                // вставляем полученные записи после имеющихся в наш блок
                $('.list-view').prepend(data);
 
                // если достигли максимальной страницы, то прячем кнопку
                if (page <= 1)
                    $('#show-more-messages-button').hide();
            }
        });
    }
    return false;
}

$(document).ready(function() {
    // проверяем новые сообщения
    if($('.chat').length){
        setInterval(function() {
            checkNewMessages();
        }, 3000);
    };
    
    // скрываем стандартный навигатор
    $('.pagination').hide(); 
    
    loadingMessagesFlag = false;
    // текущая страница
    page = $('#show-more-messages-button').data('current-page');
    pageCount = $('#show-more-messages-button').data('count-page');
    
    // загружаем пользователей
    $('#show-more-messages-button').click(loadMessages);
    
});