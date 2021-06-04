import * as React from "react";
import MUIDataTable, { MUIDataTableColumn } from "mui-datatables";
import { useEffect } from "react";
import { useState } from "react";
import { httpVideo } from "../../util/http/index";
import format from "date-fns/format";
import parseISO from "date-fns/parseISO";
import { BadgeNo, BadgeYes } from "../../components/Badge";
import { Genre, ListResponse } from "../../util/models";
import genreHttp from "../../util/http/genre-http";

const columnsDefiniton: MUIDataTableColumn[] = [
  {
    name: "name",
    label: "Nome",
  },
  {
    name: "categories",
    label: "Categorias",
    options: {
      customBodyRender(value, tableMeta, updateValue) {
        // @ts-ignore
        return value.map((category) => category.name).join(", ");
      },
    },
  },
  {
    name: "is_active",
    label: "Ativo?",
    options: {
      customBodyRender(value, tableMeta, updateValue) {
        return value ? <BadgeYes /> : <BadgeNo />;
      },
    },
  },
  {
    name: "created_at",
    label: "Criado em",
    options: {
      customBodyRender(value, tableMeta, updateValue) {
        return <span>{format(parseISO(value), "dd/MM/yyyy")}</span>;
      },
    },
  },
];

const Table = () => {
  const [data, setData] = useState<Genre[]>([]);

  useEffect(() => {
    genreHttp
      .list<ListResponse<Genre>>()
      .then((response) => setData(response.data.data));
  }, []);
  return (
    <MUIDataTable
      title=""
      columns={columnsDefiniton}
      data={data}
      options={{ enableNestedDataAccess: "." }}
    />
  );
};

export default Table;
