import * as React from 'react';
import MUIDataTable, { MUIDataTableColumn } from 'mui-datatables';
import { useEffect } from 'react';
import { useState } from 'react';
import { httpVideo } from '../../util/http/index';
import { Chip } from '@material-ui/core';
import format from 'date-fns/format';
import parseISO from 'date-fns/parseISO';

const columnsDefiniton: MUIDataTableColumn[] = [
  {
    name: 'name',
    label: 'Nome',
  },
  {
    name: 'categories',
    label: 'Categorias',
    options: {
      customBodyRender(value, tableMeta, updateValue) {
        console.log(value);
        return 'teste';
        // return value.map((category) => category.name).join(', ');
      },
    },
  },
  {
    name: 'is_active',
    label: 'Ativo?',
    options: {
      customBodyRender(value, tableMeta, updateValue) {
        return value ? (
          <Chip label="Sim" color={'primary'}></Chip>
        ) : (
          <Chip label="Não" color={'secondary'}></Chip>
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
    httpVideo.get('genres').then((response) => setData(response.data.data));
  }, []);
  return (
    <MUIDataTable
      title=""
      columns={columnsDefiniton}
      data={data}
      options={{ enableNestedDataAccess: '.' }}
    />
  );
};

export default Table;
