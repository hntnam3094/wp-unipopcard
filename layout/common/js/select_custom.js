(function($) {
    $(document).ready(function() {
      var customSelect = $(".custom-select");
  
      customSelect.each(function() {
        var thisCustomSelect = $(this),
          options = thisCustomSelect.find("option"),
          firstOptionText = options.first().text();
  
        var selectedItem = $("<div></div>", {
          class: "selected-item"
        })
          .appendTo(thisCustomSelect)
          .text(firstOptionText);
  
        var allItems = $("<div></div>", {
          class: "all-items all-items-hide"
        }).appendTo(thisCustomSelect);
  
        options.each(function() {
          var that = $(this),
            optionText = that.text();
  
          var item = $("<div></div>", {
            class: "item",
            on: {
              click: function() {
                var selectedOptionText = that.text();
                selectedItem.text(selectedOptionText).removeClass("arrowanim");
                allItems.addClass("all-items-hide");
              }
            }
          })
            .appendTo(allItems)
            .text(optionText);
        });
      });
  
      var selectedItem = $(".selected-item"),
        allItems = $(".all-items");
  
      selectedItem.on("click", function(e) {
        var currentSelectedItem = $(this),
          currentAllItems = currentSelectedItem.next(".all-items");
  
        allItems.not(currentAllItems).addClass("all-items-hide");
        selectedItem.not(currentSelectedItem).removeClass("arrowanim");
  
        currentAllItems.toggleClass("all-items-hide");
        currentSelectedItem.toggleClass("arrowanim");
  
        e.stopPropagation();
      });
  
      $(document).on("click", function() {
        var opened = $(".all-items:not(.all-items-hide)"),
          index = opened.parent().index();
  
        customSelect
          .eq(index)
          .find(".all-items")
          .addClass("all-items-hide");
        customSelect
          .eq(index)
          .find(".selected-item")
          .removeClass("arrowanim");
      });
    });
  })(jQuery);
  