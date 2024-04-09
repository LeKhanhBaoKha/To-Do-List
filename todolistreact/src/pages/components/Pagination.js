import * as React from "react";
import Pagination from "@mui/material/Pagination";
import Stack from "@mui/material/Stack";
function Paging({ links, fetchData }) {
  const [page, setPage] = React.useState(links["current_page"]);
  const handleChange = (event, value) => {
    const timeoutId = setTimeout(() => {
      fetchData(links["links"][value]["url"]);
      setPage(value);
      sessionStorage.setItem("current_page", links["links"][value]["url"]);
    }, 150);
    return () => clearTimeout(timeoutId);
  };
  return (
    <div className="z-[1000]">
      <Stack spacing={2}>
        <Pagination
          count={links["last_page"]}
          page={page}
          onChange={handleChange}
          variant="outlined"
          color="secondary"
          sx={{ zIndex: "mobileStepper" }}
        />
      </Stack>
    </div>
  );
}

export default Paging;
