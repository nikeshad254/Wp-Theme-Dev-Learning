// args: Short Name or Variable Names , Configuration Object
wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "Common",
  edit: function () {
    // what you will see in admin
    return wp.element.createElement(
      "h3",
      null,
      "Hello, This is From the admn editor screen"
    );
  },
  save: function () {
    // what user will see on frontend
    return wp.element.createElement("h3", null, "Hello, This is FrontEnd");
  },
});
