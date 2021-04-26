import { Box, Fab } from '@material-ui/core';
import * as React from 'react';
import { Link } from 'react-router-dom';
import { Page } from '../../components/Page';
import AddICon from '@material-ui/icons/Add';
import Table from './Table';

const PageList = () => {
  return (
    <Page title={'Listar gêneros'}>
      <Box dir={'rtl'} paddingBottom={2}>
        <Fab
          title="Adicionar gêneros"
          color={'secondary'}
          size="small"
          component={Link}
          to="/genres/create"
        >
          <AddICon />
        </Fab>
      </Box>
      <Box>
        <Table></Table>
      </Box>
    </Page>
  );
};
export default PageList;
