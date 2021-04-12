import * as React from 'react';
import MUIDataTable, { MUIDataTableColumn } from 'mui-datatables';
import { useEffect } from 'react';
import { useState } from 'react';
import { httpVideo } from '../../util/http/index';
import { Chip } from '@material-ui/core';
import format from 'date-fns/format';
import parseISO from 'date-fns/parseISO';

const CastMenberTypeMap = {
  '1': 'Diretor',
  '2': 'Ator',
};

const columnsDefiniton: MUIDataTableColumn[] = [
  {
    name: 'name',
    label: 'Nome',
  },
  {
    name: 'type',
    label: 'Tipo?',
    options: {
      customBodyRender(value, tableMeta, updateValue) {
        return value == '1' ? (
          <Chip label="Diretor" color={'primary'}></Chip>
        ) : (
          <Chip label="Ator" color={'secondary'}></Chip>
        );
      },
    },
  },
  {
    name: 'created_at',
    label: 'Criado em',
    options: {
      customBodyRender(value, tableMeta, updateValue) {
        return <span>{format(parseISO(value), 'dd/MM/yyyy')}</span>;
      },
    },
  },
];

const Table = () => {
  const [data, setData] = useState([]);

  useEffect(() => {
    httpVideo
      .get('cast_menbers')
      .then((response) => setData(response.data.data));
  }, []);
  return <MUIDataTable title="" columns={columnsDefiniton} data={data} />;
};

export default Table;
