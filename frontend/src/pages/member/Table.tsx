import * as React from 'react';
import MUIDataTable, { MUIDataTableColumn } from 'mui-datatables';
import { useEffect } from 'react';
import { useState } from 'react';
import { httpVideo } from '../../util/http/index';
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
        return CastMenberTypeMap[value];
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
      .get('cast_members')
      .then((response) => setData(response.data.data));
  }, []);
  return <MUIDataTable title="" columns={columnsDefiniton} data={data} />;
};

export default Table;
