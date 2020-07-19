const presets = [
  [
    '@babel/preset-env',
    {
      targets: {
        firefox: '60',
        chrome: '70',
        ie: '11',
        edge: '44',
        safari: '11',
        opera: '50',
      },
      modules: false,
    },
  ],
];

const plugins = [ '@babel/plugin-proposal-class-properties' ];

module.exports = {
  presets,
  plugins,
};
