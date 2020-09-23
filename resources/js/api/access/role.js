import request from '@/utils/request';
import Resource from '@/utils/resource';

class RoleResource extends Resource {
  constructor() {
    super('roles');
  }

  permissions(id) {
    return request({
      url: `/${this.uri}/${id}/permissions`,
      method: 'get',
    });
  }

  updatePermissions(id, permissions) {
    return request({
      url: `/${this.uri}/${id}/permissions`,
      method: 'put',
      data: { permissions },
    });
  }
}

export default new RoleResource;
