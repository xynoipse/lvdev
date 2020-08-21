import roles from './roles';
import permissions from './permissions';

const accessControl = [];
export default accessControl.concat(
  roles,
  permissions
);
