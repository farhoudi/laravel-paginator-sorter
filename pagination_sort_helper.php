<?php
/**
 * pagination sorting helper
 *
 * @author Ali Farhoudi
 */


/**
 * get sort url
 *
 * @author Ali Farhoudi
 * @param $column
 * @return string
 */
function get_sort_url($column) {
    $url = $_SERVER['REQUEST_URI'];
    $url_parts = parse_url($url);

    if (!isset($url_parts['query'])) {
        return array('sort' => $column . '-' . 'asc');
    }

    parse_str($url_parts['query'], $params);

    $sort_array = isset($params['sort']) ? explode('-', $params['sort']) : array($column, 'desc');
    if ($sort_array[0] === $column) {
        $new_order = ($sort_array[1] === 'asc') ? 'desc' : 'asc';
    } else {
        $new_order = 'asc';
    }

    $new_sort_conditions = $column . '-' . $new_order;

    $params['sort'] = $new_sort_conditions;     // Overwrite if exists

    return $params;
}

/**
 * get sort conditions
 *
 * @author Ali Farhoudi
 * @return array
 */
function get_sort_conditions() {
    $sort_array = Input::get('sort');

    if ($sort_array) {
        $sort_array = explode('-', $sort_array);
        $column = $sort_array[0];
        $order = $sort_array[1];
    } else {
        $column = 'id';
        $order = 'desc';
    }
    $sort_conditions = array(
        'column' => $column,
        'order' => $order,
    );

    return $sort_conditions;
}

/**
 * get pagination links
 *
 * @author Ali Farhoudi
 * @return string
 */
function get_pagination_links($object) {
    $url = $_SERVER['REQUEST_URI'];
    $url_parts = parse_url($url);

    if (!isset($url_parts['query'])) {
        return $object->links();
    }

    parse_str($url_parts['query'], $params);

    if (isset($params['page'])) {
        unset($params['page']);
    }

    return $object->appends($params)->links();
}

/**
 * get sorted object
 *
 * @author Ali Farhoudi
 * @param $object
 * @return object
 */
function get_sorted($object) {
    $sort_conditions = get_sort_conditions();
    if ($sort_conditions['column'] === 'id') {
        return $object->orderby($sort_conditions['column'], $sort_conditions['order']);
    } else {
        return $object->orderby($sort_conditions['column'], $sort_conditions['order'])
            ->orderby('id', 'desc');
    }
}