const get = (target) => {
  const row = target.parentElement.parentElement.parentElement;
  const actions = target.parentElement.children;
  return { row, actions };
}

export function disableRow(target) {
  const { row, actions } = get(target);
  row.classList.add('text-muted');
  actions.forEach(action => {
    action.disabled = true;
  });
}

export function enableRow(target) {
  const { row, actions } = get(target);
  row.classList.remove('text-muted');
  actions.forEach(action => {
    action.disabled = false;
  });
}
