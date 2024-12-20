import "./index.scss";
import { useSelect } from "@wordpress/data";
import { useState, useEffect } from "react";
import apiFetch from "@wordpress/apiFetch";

const __ = wp.i18n.__;

wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description:
    "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    profId: { type: "string" },
  },
  edit: EditComponent,
  save: function () {
    return null;
  },
});

function EditComponent(props) {
  const [thePreview, setPreview] = useState("");

  useEffect(() => {
    if (props.attributes.profId) {
      updateTheMeta();
      async function getData() {
        const response = await apiFetch({
          path: `/featuredProfessor/v1/getHTML?profId=${props.attributes.profId}`,
          method: "GET",
        });
        setPreview(response);
      }

      getData();
    }
    setPreview("");
  }, [props.attributes.profId]);

  useEffect(() => {
    return () => {
      updateTheMeta();
    };
  }, []);

  function updateTheMeta() {
    const profsForMeta = wp.data
      .select("core/block-editor")
      .getBlocks()
      .filter((x) => x.name == "ourplugin/featured-professor")
      .map((x) => x.attributes.profId)
      .filter((x, index, arr) => {
        return arr.indexOf(x) === index;
      });

    wp.data
      .dispatch("core/editor")
      .editPost({ meta: { featuredprofessor: profsForMeta } });
  }

  const allProfs = useSelect((select) => {
    return select("core").getEntityRecords("postType", "professor", {
      per_page: -1,
    });
  });

  if (allProfs == undefined) return <p>Loading . . . </p>;

  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select
          onChange={(e) => props.setAttributes({ profId: e.target.value })}
        >
          <option value="">
            {__("Select a professor", "featured-professor")}
          </option>
          {allProfs.map((prof) => (
            <option
              value={prof.id}
              key={prof.id}
              selected={props.attributes.profId == prof.id}
            >
              {prof.title.rendered}
            </option>
          ))}
        </select>
      </div>
      <div dangerouslySetInnerHTML={{ __html: thePreview }}></div>
    </div>
  );
}
