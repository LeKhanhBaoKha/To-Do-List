import * as React from 'react';
import Pagination from '@mui/material/Pagination';
import Stack from '@mui/material/Stack';
function Paging(links, fetchData){
    console.log('last page', links['last_page'])
    const [page, setPage] = React.useState(links['current_page']);
    const handleChange = (event, value) => {

      console.log('page links', links['links'][value]['url']);
      const timeoutId = setTimeout(() => {
        fetchData(links['links'][value]['url']);
        setPage(value);
        sessionStorage.setItem('current_page', links['links'][value]['url']);
      }, 150); // 150 milliseconds = 0.15 seconds
      return () => clearTimeout(timeoutId);
    };
    return (
      <Stack spacing={2}>
        <Pagination count={links['last_page']} page={page} onChange={handleChange} variant="outlined" color="secondary"/>
      </Stack>
    );
}

export default Paging