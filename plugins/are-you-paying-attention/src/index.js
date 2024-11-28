// args: Short Name or Variable Names , Configuration Object
wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "Common",
  edit: function () {
    // what you will see in admin
    return (
      <div>
        <p>Hello, this is paragraph</p>
      </div>
    );
  },
  save: function () {
    // what user will see on frontend
    return (
      <div>
        <h3>asjdlsjds</h3>
      </div>
    );
  },
});
