$(document).delegate('.image_delete_btn', 'click', function() { 
                        alert('ok');
                        var id = $(this).attr('data_id');
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : "<?php echo Url::toRoute('page/delete_uploaded_file'); ?>",
                            data: {id:id},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     $('.image_'+id).remove();
                                }
                        })
                    });