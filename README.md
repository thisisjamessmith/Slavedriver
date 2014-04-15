Slavedriver
===========

Sites created with ExpressionEngine's multiple site manager (MSM) are typically strongly separated from each other. The documentation itself states in several places that there is no such concept as a 'master' site, and all sites are on an equal footing. This gives you a huge amount of flexibility to allow each site to become whatever it needs to be, but the drawback is that it can make cross-site sharing harder, sometimes requiring duplicate templates and entries, or convoluted cross-site template embeds.

With Slavedriver you can specify a single site as the master and allow configs to cascade down into the 'slave' sites.

Usage
------------

Currently Slavedriver does only one thing: it shares your Pages Module configuration (URIs and templates) from the master site to make them accessible in the currently viewed slave site.

So this means you can point to a Pages Module URI from a slave site, and it will route to exactly the same template and the same channel entry as if you were on the master site. This approach allows you to use field-level overrides or even separate entries or separate channels via template logic if you need to slightly alter the content for a given slave site.


Change log
--------------

* v.0.2.1: Initial Release
