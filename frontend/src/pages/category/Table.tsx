import * as React from "react";
import MUIDataTable, { MUIDataTableColumn } from "mui-datatables";
import { useEffect } from "react";
import { useState } from "react";
import format from "date-fns/format";
import parseISO from "date-fns/parseISO";
import categoryHttp from "../../util/http/category-http";
import { Category, ListResponse } from "../../util/models";

import { BadgeYes, BadgeNo } from "../../components/Badge";

const columnsDefiniton: MUIDataTableColumn[] = [
  {
    name: "name",
    label: "Nome",
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
  const [data, setData] = useState<Category[]>([]);

  useEffect(() => {
    categoryHttp
      .list<ListResponse<Category>>()
      .then(({ data }) => setData(data.data));
  }, []);
  return <MUIDataTable title="" columns={columnsDefiniton} data={data} />;
};

export default Table;
