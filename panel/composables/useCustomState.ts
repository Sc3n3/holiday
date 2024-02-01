export default function (name, value) {
    name = name || Date.now().toString(36) + Math.random().toString(36).substr(2);

    const state = useState(name, value);
    const setState = (value) => state.value = value;

    return [ state, setState ];
}