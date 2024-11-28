// args: Short Name or Variable Names , Configuration Object
wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "Common",
  attributes: {
    skyColor: { type: "string" },
    grassColor: { type: "string" },
  },
  edit: function (props) {
    function updateSkyColor(e) {
      props.setAttributes({
        skyColor: e.target.value,
      });
    }

    function updateGrassColor(e) {
      props.setAttributes({
        grassColor: e.target.value,
      });
    }
    // what you will see in admin
    return (
      <div>
        <input
          type="text"
          placeholder="sky color"
          value={props.attributes.skyColor}
          onChange={updateSkyColor}
        />
        <input
          type="text"
          placeholder="grass color"
          value={props.attributes.grassColor}
          onChange={updateGrassColor}
        />
      </div>
    );
  },
  save: function (props) {
    // what user will see on frontend
    return null;
  },
});
