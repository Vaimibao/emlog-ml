<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
</div>
</div>
<?php if (AI::model()): ?>
    <a class="ai-chat-button" href="#" data-toggle="modal" data-target="#aiChatModal">
        <span>✨</span>
    </a>
<?php endif; ?>
<a class="scroll-to-top" href="#page-top">
    <i class="icofont-rounded-up"></i>
</a>
<footer class="sticky-footer">
    <div class="rem13">
        <a href="https://www.emlog.net" target="_blank">EMLOG</a> - <?= ucfirst(Option::EMLOG_VERSION) ?>
    </div>
</footer>
<!-- AI Chat Modal -->
<div class="modal fade" id="aiChatModal" tabindex="-1" role="dialog" aria-labelledby="aiChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="aiChatModalLabel">✨<?= lang('ai_conversation') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="chat-box" style="height: 500px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 8px;">
                    <!-- Chat messages will appear here -->
                </div>
                <form id="chat-form">
                    <div class="input-group">
                        <textarea class="form-control" id="chat-input" placeholder="<?= lang('input_ai_msg') ?>" rows="1" style="resize: none; overflow: hidden;"></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="send-btn"><?= lang('send') ?></button>
                        </div>
                    </div>
                    <div class="text-muted text-xs mt-2">Model：<?= AI::model() ? AI::model() : lang('no_ai_model') ?><?= lang('press_shift_enter') ?></div>
                </form>
                <script>
                    $(document).ready(function() {
                        $('#chat-input').on('input', function() {
                            this.style.height = 'auto';
                            this.style.height = (this.scrollHeight) + 'px';
                            $('#send-btn').css('height', this.style.height);
                        });

                        $('#chat-input').on('keydown', function(event) {
                            if (event.key === 'Enter' && !event.shiftKey) {
                                event.preventDefault();
                                $('#send-btn').click();
                            }
                        });

                        $('#chat-form').submit(function() {
                            $('#chat-input').css('height', 'auto');
                            $('#send-btn').css('height', 'auto');
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- Shortcut Modal -->
<div class="modal fade" id="shortcutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="shortcutModalLabel"><?= lang('fast_entry') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php?action=add_shortcut" method="post">
                <div class="modal-body" id="shortcutModalBody">
                    <p class="text-center"><?= lang('loading') ?></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= lang('save') ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
</div>
<?php doAction('adm_footer') ?>
<script src="./views/js/sb-admin-2.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    $(function() {
        // Scroll to top button appear
        $(document).on('scroll', function() {
            var scrollDistance = $(this).scrollTop();
            if (scrollDistance > 100) {
                $('.scroll-to-top').fadeIn();
            } else {
                $('.scroll-to-top').fadeOut();
            }
        });
        // Smooth scrolling using jQuery easing
        $(document).on('click', 'a.scroll-to-top', function(e) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: ($($anchor.attr('href')).offset().top)
            }, 1000, 'easeInOutExpo');
            e.preventDefault();
        });

        //pjax
        $(document).pjax('a[data-pjax]', '#main-container', {
            fragment: '#main-container',
            timeout: 5000
        });
        $(document).on('pjax:success', function() {
            initPageScripts();
            // Rebind sidebar toggle event
            $("#sidebarToggleTop").off('click').on('click', function() {
                window.toggleSidebar();
            });
        });
        $(document).on('pjax:beforeSend', function() {
            closePageScripts();
        });

        // Time selection control
        $.timepicker.regional['zh-CN'] = {
            timeOnlyTitle: '选择时间',
            timeText: '时间',
            hourText: '时',
            minuteText: '分',
            secondText: '秒',
            millisecText: '毫秒',
            microsecText: '微秒',
            timezoneText: '时区',
            currentText: '现在时间',
            closeText: '关闭',
            timeFormat: 'HH:mm',
            timeSuffix: '',
            amNames: ['AM', 'A'],
            pmNames: ['PM', 'P'],
            isRTL: false,
            prevText: '上个月',
            nextText: '下个月',
            showMonthAfterYear: true,
            weekHeader: '周',
            yearSuffix: '年',
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        };

        $.timepicker.setDefaults($.timepicker.regional['<?= LANG ?>']);
        let monthNamesShort = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
        const screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        let _left = screenWidth < 1200 ? 0 : 50;
        $(".datepicker").length && $(".datepicker").datetimepicker({
            controlType: "select",
            monthNamesShort: monthNamesShort,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-30:c+10",
            showSecond: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            beforeShow: function(input, inst) {
                setTimeout(function() {
                    inst.dpDiv.css({
                        top: $(".datepicker.active").offset().top + 50,
                        left: $(".datepicker.active").offset().left - _left
                    });
                }, 0);
            },
            onClose: function(dateText, inst) {
                typeof onDatepickerClose === "function" && onDatepickerClose(dateText, inst);
            }
        });
        $('body').on('focus', '.datepicker', function() {
            let _this = $(this)
            $('.datepicker').removeClass('active')
            _this.addClass('active')
        })

        // AI Chat
        $('#aiChatModal').on('shown.bs.modal', function() {
            $('#chat-input').focus();
        });

        $('#chat-form').submit(function(event) {
            event.preventDefault();
            var message = $('#chat-input').val().trim();
            if (message === '') return;

            // Show user messages
            $('#chat-box').append('<div style="background-color:#69b4ff; color:#FFFFFF; border-radius: 10px; padding: 10px; margin: 5px 0;"><b>😄：</b> ' + $('<div>').text(message).html() + '</div>');
            $('#chat-input').val('');
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

            var $sendBtn = $('#send-btn');
            $sendBtn.prop('disabled', true).text('<?= lang('sending') ?>');

            // Initialize EventSource for streaming communication
            var eventSource = new EventSource('ai.php?action=chat_stream&message=' + encodeURIComponent(message));
            var $aiMessage = $('<div style="background-color: #f1f1f1; border-radius: 10px; padding: 10px; margin: 5px 0;"><b>🤖：</b> <span class="ai-typing"></span></div>');
            $('#chat-box').append($aiMessage);

            eventSource.onmessage = function(event) {
                if (event.data === '[DONE]') {
                    $sendBtn.prop('disabled', false).text('<?= lang('send') ?>');
                    eventSource.close();
                } else {
                    try {
                        var data = JSON.parse(event.data);
                        if (data.choices && data.choices[0].delta && (data.choices[0].delta.content || data.choices[0].delta.reasoning_content)) {
                            var chunk = data.choices[0].delta.content;
                            var rchunk = data.choices[0].delta.reasoning_content;
                            var $typing = $aiMessage.find('.ai-typing');
                            var currentContent = $typing.html();
                            if (chunk) {
                                $typing.html(currentContent + $('<div>').text(chunk).html().replace(/\n/g, '<br>'));
                            } else if (rchunk) {
                                $typing.html(currentContent + $('<div>').text(rchunk).html().replace(/\n/g, '<br>'));
                            }
                            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                        }
                    } catch (err) {
                        console.error('<?= lang('error_parsing_stream_data') ?>:', err);
                    }
                }
            };

            eventSource.onerror = function() {
                var $typing = $aiMessage.find('.ai-typing');
                var currentContent = $typing.html();
                $typing.html(currentContent + "<?= lang('ai_connection_error') ?>");
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                $sendBtn.prop('disabled', false).text('<?= lang('send') ?>');
                eventSource.close();
            };
        });

        // Initialize shortcut bar hover effect
        initShortcutBar();
        $('#shortcutModal').on('show.bs.modal', function(event) {
            const modalBody = $('#shortcutModalBody');
            modalBody.html('<p class="text-center"><?= lang('loading') ?></p>');
            const currentShortcuts = <?php echo json_encode($shortcuts); ?>;
            $.ajax({
                url: 'index.php?action=get_all_shortcuts',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (!response.code && response.data) {
                        modalBody.empty();
                        if (!response.data.length) {
                            modalBody.html('<p class="text-center"><?= lang('no_shortcuts') ?></p>');
                            return;
                        }
                        response.data.forEach((item, index) => {
                            const isChecked = currentShortcuts.some(s =>
                                s.name === item.name && s.url === item.url
                            );
                            modalBody.append(
                                $('<input>', {
                                    type: 'checkbox',
                                    name: 'shortcut[]',
                                    id: 'shortcut-' + index,
                                    value: item.name + '||' + item.url,
                                    checked: isChecked
                                }),
                                $('<label>', {
                                    for: 'shortcut-' + index,
                                    class: 'mr-2',
                                    text: item.name
                                })
                            );
                        });
                    } else {
                        modalBody.html('<?= lang('_load_failed') ?>' + (response.msg || lang('unknown_error')));
                    }
                },
                error: (_, __, error) => modalBody.html('<?= lang('_load_failed') ?>' + error)
            });
        });
    });
</script>
</body>

</html>