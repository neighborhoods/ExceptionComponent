# Neighborhoods Exception Component
Provides a consistent transient and non-transient exception types.

These are primarily intended to be used in Repositories. Repositories are experts at interacting with their associated storages. They should catch storage exceptions, interpret them (since a lot of storage exceptions have esoteric codes or, worse, esoteric message strings that need to be identified for certain cases) and decompose the specific storage exception to be either Transient (this will get better) or NonTransient (this needs a human, i.e. it will not get better.)

## Example
```php
        try {
            $connection->beginTransaction();
            // ...
            $connection->commit();
        } catch (PDOException $pdoException) {
            $connection->rollBack();
            if($pdoException->getCode() === RepositoryInterface::POSTGRES_CONNECTION_EXCEPTION_CODE) {
              throw (new TransientException())->setPrevious($pdoException);
            } elseif ($pdoException->getCode() === RepositoryInterface::PARREL_WORKER_UNIQUE_CONSTRAINT_MUTEX) {
              // This constraint prevents race conditions between multiple workers and is triggered in those scenarios by design.
              // It can be ignored.
            } else { 
              throw (new NonTransientException())->setPrevious($pdoException);
            }
        }
```
