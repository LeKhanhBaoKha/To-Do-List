import * as React from 'react';
import Pagination from '@mui/material/Pagination';
import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
function Paging(links, fetchData){
    // console.log('page links', links['links'])
    console.log('last page', links['last_page'])
    // {
    //     url: links[1]['url'],
    //     label: links[1]['label'],
    //     active: links[1]['active']
    // }
    
    const [page, setPage] = React.useState(links['current_page']);
    const handleChange = (event, value) => {

      console.log('page links', links['links'][value]['url']);
      const timeoutId = setTimeout(() => {
        fetchData(links['links'][value]['url']);
        setPage(value);
        sessionStorage.setItem('current_page', links['links'][value]['url']);
      }, 150); // 5000 milliseconds = 5 seconds
      return () => clearTimeout(timeoutId);
    };
    return (
      <Stack spacing={2}>
        <Pagination count={links['last_page']} page={page} onChange={handleChange} variant="outlined" color="secondary"/>
      </Stack>
    );

    // const [page, setPage] = React.useState(1);
    // const handleChange = (event, value) => {
    //   setPage(value);
    // };

    // return (
    //   <Stack spacing={2}>
    //     <Typography>Page: {page}</Typography>
    //     <Pagination count={10} page={page} onChange={handleChange} />
    //   </Stack>
    // );
}

export default Paging