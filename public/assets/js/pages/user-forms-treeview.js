'use strict';
//  Author: ThemeREX.com
//  user-forms-treeview.html scripts
//

(function ($) {

    $(document).ready(function () {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Init FancyTree
        $("#tree").fancytree({
            icons: false, // Don't show node icons
            clickFolderMode: 2 // 1:activate
                               // 2:expand
                               // 3:activate and expand
                               // 4:activate and expand on doubleclick
        });

        // Init FancyTree - With Icons
        $("#tree2").fancytree({
            clickFolderMode: 2 // 1:activate
                               // 2:expand
                               // 3:activate and expand
                               // 4:activate and expand on doubleclick
        });

        // Init FancyTree - With Checkboxes
        $("#tree3").fancytree({
            selectMode: 3,
            checkbox: true,
            clickFolderMode: 2 // 1:activate
                               // 2:expand
                               // 3:activate and expand
                               // 4:activate and expand on doubleclick
        });

        // Init FancyTree - With Checkboxes
        $("#tree4").fancytree({
            selectMode: 1,
            checkbox: true,
            clickFolderMode: 2 // 1:activate
                               // 2:expand
                               // 3:activate and expand
                               // 4:activate and expand on doubleclick
        });

        // Init FancyTree - With Childcounter
        $("#tree5").fancytree({
            extensions: ["childcounter"],
            childcounter: {
                deep: true,
                hideZeros: true,
                hideExpanded: true
            }
        });

        // Attach fancytree widget <div id="tree"> element
        // and pass tree options as arguments to the fancytree() function
        $("#columnview").fancytree({
            extensions: ["columnview"],
            checkbox: true,
            source: {
                url: "assets/js/plugins/fancytree/ajax-tree-plain2.json"
            },
            lazyLoad: function (event, data) {
                data.result = {
                    url: "assets/js/plugins/fancytree/ajax-sub2.json"
                };
            },
            activate: function (event, data) {
                $("td#preview").text("activate " + data.node);
            },
            select: function (event, data) {
                // Add tag when node is selected
                var node = data.node;
                $("span#tag-" + node.key).remove();
                if (node.selected) {
                    $("<span>", {
                        id: "tag-" + node.key,
                        text: node.title,
                        "class": "selTag"
                    })
                        .data("key", node.key)
                        .appendTo($("td#tags"));
                }
            }
        });

        // Init FancyTree - w/Drag and Drop
        $("#tree6").fancytree({
            extensions: ["dnd", "edit"],
            source: {
                url: "assets/js/plugins/fancytree/ajax-tree-plain.json"
            },
            dnd: {
                autoExpandMS: 400,
                focusOnClick: true,
                preventVoidMoves: true,
                preventRecursiveMoves: true,
                dragStart: function (node, data) {
                    return true; // true - enable dragging, false - disable dragging
                },
                dragEnter: function (node, data) {
                    return true; //false = disallow on-node dropping
                },
                dragDrop: function (node, data) {
                    data.otherNode.moveTo(node, data.hitMode); // allow on-tree item dropping
                }
            },
            activate: function (event, data) {
            },
            lazyLoad: function (event, data) {
                data.result = {
                    url: "ajax-sub2.json"
                }
            }
        });

        // Init FancyTree - w/Inline Editing
        $("#tree7").fancytree({
            extensions: ["edit"],
            source: {
                url: "assets/js/plugins/fancytree/ajax-tree-plain.json"
            },
            lazyLoad: function (event, data) {
                data.result = {
                    url: "ajax-sub2.json",
                    debugDelay: 1000
                };
            },
            edit: {
                triggerStart: ["f2", "dblclick", "shift+click", "mac+enter"],
                beforeEdit: function (event, data) {
                    // Return false = prevent edit mode
                },
                edit: function (event, data) {
                    // Editor was opened
                },
                beforeClose: function (event, data) {
                    // Return false =  prevent cancel/save
                },
                save: function (event, data) {
                    // return false = keep editor open
                    setTimeout(function () {
                        $(data.node.span).removeClass("pending");
                        data.node.setTitle(data.node.title + "!");
                    }, 2000);
                    // Return true - set current user input as title
                    return true;
                },
                close: function (event, data) {
                    // Editor was removed
                    if (data.save) {
                        // Set node as preliminary because of async request
                        $(data.node.span).addClass("pending");
                    }
                }
            }
        });

        // Attach fancytree widget <div id="tree"> element
        // and pass tree options as arguments to the fancytree() function
        $("#tree8").fancytree({
            extensions: ["filter"],
            quicksearch: true,
            source: {
                url: "assets/js/plugins/fancytree/ajax-tree-local.json"
            },
            filter: {
                mode: "hide",
                autoApply: true
            },
            activate: function (event, data) {},
            lazyLoad: function (event, data) {
                data.result = {
                    url: "assets/js/plugins/fancytree/ajax-sub2.json"
                }
            }
        });
        var tree = $("#tree8").fancytree("getTree");
        $("input[name=search]").keyup(function (e) {
            var n,
                leavesOnly = $("#leavesOnly").is(":checked"),
                match = $(this).val();

            if (e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === "") {
                $("button#btnResetSearch").click();
                return;
            }
            if ($("#regex").is(":checked")) {
                // Perform match by passing a function
                n = tree.filterNodes(function (node) {
                    return new RegExp(match, "i").test(node.title);
                }, leavesOnly);
            } else {
                // Perform case insensitive matching by passing a string
                n = tree.filterNodes(match, leavesOnly);
            }
            $("button#btnResetSearch").attr("disabled", false);
            $("span#matches").text("(" + n + " matches)");
        });

        $("button#btnResetSearch").click(function (e) {
            $("input[name=search]").val("");
            $("span#matches").text("");
            tree.clearFilter();
        }).attr("disabled", true);

        tree.options.filter.mode = $("input#hideMode").is(":checked") ? "hide" : "dimm";
        tree.clearFilter();

        $("input#hideMode").change(function (e) {
            tree.options.filter.mode = $(this).is(":checked") ? "hide" : "dimm";
            tree.clearFilter();
            $("input[name=search]").keyup();
        });
        $("input#leavesOnly").change(function (e) {
            tree.clearFilter();
            $("input[name=search]").keyup();
        });
        $("input#regex").change(function (e) {
            tree.clearFilter();
            $("input[name=search]").keyup();
        });
    });

})(jQuery);
