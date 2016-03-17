

$(document).ready(function(){
            var ns = $('ol.sortable').nestedSortable({
                forcePlaceholderSize: true,
                handle: 'div',
                helper: 'clone',
                items: 'li',
                opacity: .6,
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                toleranceElement: '> div',
                maxLevels: 4,
                isTree: true,
                expandOnHover: 700,
                startCollapsed: false,
                stop: function(){
                    arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
                    arraied = dump(arraied);
                    (typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
                    $('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
                }
            });
            
            $('.expandEditor').attr('title','Click to show/hide item editor');
            $('.disclose').attr('title','Click to show/hide children');
            $('.deleteMenu').attr('title', 'Click to delete item.');
        
            $('.disclose').on('click', function() {
                $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
                $(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
            });
            
            $('.expandEditor, .itemTitle').click(function(){
                var id = $(this).attr('data-id');
                $('#menuEdit'+id).toggle();
                $(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
            });
            
            $(document).delegate('.deleteMenu', 'click', function() { 
                //console.log($(this).parents('li').html());
                $(this).parent().parent().parent().remove();
            });

            $(document).delegate('.delegate', 'click', function() { 
                alert('ok');
            });
            
                
            $('#serialize').click(function(){
                serialized = $('ol.sortable').nestedSortable('serialize');
                $('#serializeOutput').text(serialized+'\n\n');
            })
    
            $('#toHierarchy').click(function(e){
                hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
                hiered = dump(hiered);
                (typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
                $('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
            })
    
            $('#toArray').click(function(e){
                arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
                arraied = dump(arraied);
                (typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
                $('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
            });



            $('.add').click(function(){
                var page_title=$('.page_select option:selected').text();
                var page_id=$('.page_select').val();
                var item_title=$('.item_title').val();


                var html='<li class="mjs-nestedSortable-leaf" id="menuItem_'+page_id+'">';
                       html+='<div class="menuDiv">';
                           
                           html+='<span>';
                               html+='<span data-id="'+page_id+'" class="itemTitle">'+item_title+'</span>';
                               html+='<span title="Click to delete item." data-id="'+page_id+'" class="deleteMenu ui-icon ui-icon-closethick">';
                                    html+='<span class="glyphicon glyphicon-trash"></span>';
                               html+='</span>';
                           html+='</span>';
                           html+='<div id="menuEdit'+page_id+'" class="menuEdit">';
                               html+='<p>';
                                   html+=page_title;
                               html+='</p>';
                           html+='</div>';
                       html+='</div>';
                    html+='</li>';
                


                $('.sortable').append(html);
            });


            


        });        

    
        function dump(arr,level) {
            var dumped_text = "";
            if(!level) level = 0;
    
            //The padding given at the beginning of the line.
            var level_padding = "";
            for(var j=0;j<level+1;j++) level_padding += "    ";
    
            if(typeof(arr) == 'object') { //Array/Hashes/Objects
                for(var item in arr) {
                    var value = arr[item];
    
                    if(typeof(value) == 'object') { //If it is an array,
                        dumped_text += level_padding + "'" + item + "' ...\n";
                        dumped_text += dump(value,level+1);
                    } else {
                        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                    }
                }
            } else { //Strings/Chars/Numbers etc.
                dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
            }
            return dumped_text;
        }





       